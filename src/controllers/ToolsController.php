<?php

namespace spicyweb\oddsandends\controllers;

use Craft;
use craft\commerce\elements\Product;
use craft\commerce\elements\Variant;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\helpers\Db;
use craft\helpers\FileHelper;
use craft\models\Section;
use craft\web\Controller;
use yii\web\Response;

/**
 * Class ToolsController
 *
 * @package spicyweb\oddsandends\controllers
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class ToolsController extends Controller
{
    protected array|int|bool $allowAnonymous = true;

    /**
     * Downloads a file and cleans up old temporary assets
     */
    public function actionDownloadFile(): Response
    {
        // Sort out the file we want to download
        $id = Craft::$app->getRequest()->getParam('id');


        $query = Asset::find()->id($id);
        $asset = $query->one();

        if ($asset) {

            // Get a local copy of the file
            $localCopy = $asset->getCopyOfFile($asset);

            // Send it to the browser
            $response = Craft::$app->getResponse()->sendFile($localCopy, $asset->filename, []);
            FileHelper::unlink($localCopy);
            return $response;
        }
    }

    /**
     * Fork of tags/searchForTags adjusted to cope with any element
     */
    public function actionSearchForElements(): Response
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();

        $request = Craft::$app->getRequest();

        $search = $request->getRequiredBodyParam('search');
        $excludeIds = $request->getRequiredBodyParam('excludeIds', []);

        // // Get the post data
        $elementType = $request->getRequiredBodyParam('elementType');
        $sources = $request->getRequiredBodyParam('sources');

        // Deal with Entries
        if ($elementType == "Entry") {

            // Fangle the sections out of the sources
            $sections = [];
            if (is_array($sources)) {
                foreach ($sources as $source) {
                    switch ($source) {
                        case 'singles':
                        {
                            $sections = array_merge($sections, Craft::$app->getSections()->getSectionsByType(Section::TYPE_SINGLE));
                            break;
                        }
                        default:
                        {
                            if (preg_match('/^section:(.+)$/', $source, $matches)) {
                                $section = Craft::$app->getSections()->getSectionByUid($matches[1]);

                                if ($section) {
                                    $sections = array_merge($sections, [$section]);
                                }
                            }
                        }
                    }
                }
            } elseif ($sources === '*') {
                $sections = Craft::$app->getSections()->getAllSections();
            }

            $criteria = Entry::find();
            $criteria->section = $sections;
        }
        // Deal with Categories
        elseif ($elementType == "Category") {
            // Start the criteria
            $criteria = Category::find();
        }
        // Craft Commerce products/variants
        elseif (in_array($elementType, [Product::class, Variant::class])) {
            $productTypesService = Craft::$app->getPlugins()
                ->getPlugin('commerce')
                ->getProductTypes();
            $productTypes = [];
            if (is_array($sources)) {
                foreach ($sources as $source) {
                    if (preg_match('/^products:(.+)$/', $source, $matches)) {
                        $productType = $productTypesService->getProductTypeByUid($matches[1]);

                        if ($productType) {
                            $productTypes[] = $productType;
                        }
                    }
                }
            } elseif ($sources === '*') {
                $productTypes = $productTypesService->getAllProductTypes();
            }

            if ($elementType === Product::class) {
                $criteria = Product::find();
                $criteria->type = $productTypes;
            } else {
                $criteria = Variant::find();
                $criteria->typeId = array_map(fn($type) => $type->id, $productTypes);
            }
        }

        // Add and exclude ids
        $notIds = ['and'];

        foreach ($excludeIds as $id) {
            $notIds[] = 'not ' . $id;
        }

        // Set the rest of the criteria
        $criteria->title = '*' . Db::escapeParam($search) . '*';
        $criteria->id = $notIds;
        $criteria->status = null;
        $criteria->limit = 20;
        $elements = $criteria->all();

        $return = [];
        $exactMatches = [];
        $exactMatch = false;

        $normalizedSearch = $search;

        foreach ($elements as $element) {
            if ($elementType == "Entry") {
                if (!is_array($sources)) {
                    $sourceKey = "*";
                } elseif ($element->section->type == Section::TYPE_SINGLE) {
                    $sourceKey = "singles";
                } else {
                    $sourceKey = "section:" . $element->section->uid;
                }

                $return[$sourceKey][] = [
                    'id' => $element->id,
                    'title' => $element->title,
                    'status' => $element->status,
                    'sourceName' => $element->section->name,
                ];
            } elseif ($elementType == "Category") {
                $sourceKey = "group:" . $element->group->uid;
                $return[$sourceKey][] = [
                    'id' => $element->id,
                    'title' => $element->title,
                    'status' => $element->status,
                    'sourceName' => $element->group->name,
                ];
            } elseif ($elementType === Product::class) {
                $sourceKey = is_array($sources) ? "productType:{$element->type->uid}" : "*";
                $return[$sourceKey][] = [
                    'id' => $element->id,
                    'title' => $element->title,
                    'status' => $element->status,
                    'sourceName' => $element->type->name,
                ];
            } elseif ($elementType === Variant::class) {
                $sourceKey = is_array($sources) ? "productType:{$element->product->type->uid}" : "*";
                $return[$sourceKey][] = [
                    'id' => $element->id,
                    'title' => "{$element->product->title}: $element->title",
                    'status' => $element->status,
                    'sourceName' => $element->product->type->name,
                ];
            }

            $normalizedTitle = $element->title;

            if ($normalizedTitle == $normalizedSearch) {
                $exactMatches[] = 1;
                $exactMatch = true;
            } else {
                $exactMatches[] = 0;
            }
        }

        // NOTE: We’ve lost the sorting by exact match
        // array_multisort($exactMatches, SORT_DESC, $return);
        
        return $this->asJson([
            'elements' => $return,
            'exactMatch' => $exactMatch,
        ]);
    }
}
