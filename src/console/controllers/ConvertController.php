<?php

namespace spicyweb\oddsandends\console\controllers;

use Craft;
use craft\commerce\fields\Products as ProductsField;
use craft\commerce\fields\Variants as VariantsField;
use craft\console\Controller;
use craft\fields\Categories as CategoriesField;
use craft\fields\Entries as EntriesField;
use spicyweb\oddsandends\fields\CategoriesSearch;
use spicyweb\oddsandends\fields\EntriesSearch;
use spicyweb\oddsandends\fields\ProductsSearch;
use spicyweb\oddsandends\fields\VariantsSearch;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Actions for converting plugin functionality to equivalent Craft-native functionality.
 *
 * @package spicyweb\oddsandends\console\controllers
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @since 5.1.0
 */
class ConvertController extends Controller
{
    /**
     * Converts 'Categories (Search)' fields to Craft-native categories fields set to show their search inputs.
     *
     * @return int
     */
    public function actionCategoriesSearch(): int
    {
        return $this->_search(CategoriesSearch::class, CategoriesField::class);
    }

    /**
     * Converts 'Entries (Search)' fields to Craft-native entries fields set to show their search inputs.
     *
     * @return int
     */
    public function actionEntriesSearch(): int
    {
        return $this->_search(EntriesSearch::class, EntriesField::class);
    }

    /**
     * Converts 'Products (Search)' fields to Craft Commerce-native products fields set to show their search inputs.
     *
     * @return int
     */
    public function actionProductsSearch(): int
    {
        return $this->_search(ProductsSearch::class, ProductsField::class);
    }

    /**
     * Converts 'Variants (Search)' fields to Craft Commerce-native variants fields set to show their search inputs.
     *
     * @return int
     */
    public function actionVariantsSearch(): int
    {
        return $this->_search(VariantsSearch::class, VariantsField::class);
    }

    /**
     * Converts fields of a plugin-provided relational search field type to equivalent Craft-native fields set to show their search inputs.
     *
     * @param string $oldType the plugin-provided field class name
     * @param string $newType the Craft-native field class name
     * @return int
     */
    private function _search(string $oldType, string $newType): int
    {
        $fieldsService = Craft::$app->getFields();
        $oldFields = $fieldsService->getFieldsByType($oldType);
        $anyErrors = false;

        if (empty($oldFields)) {
            $this->stdout('No fields to convert.' . PHP_EOL);
        }

        foreach ($oldFields as $oldField) {
            $this->stdout(sprintf('Converting %s (field UID %s) ... ', $oldField->name, $oldField->uid));
            $newField = new $newType();
            $newField->id = $oldField->id;
            $newField->uid = $oldField->uid;
            $newField->name = $oldField->name;
            $newField->handle = $oldField->handle;
            $newField->instructions = $oldField->instructions;
            $newField->searchable = $oldField->searchable;
            $newField->translationMethod = $oldField->translationMethod;
            $newField->translationKeyFormat = $oldField->translationKeyFormat;
            $newField->columnSuffix = $oldField->columnSuffix;

            foreach ($oldField->settingsAttributes() as $attribute) {
                if ($attribute === 'showSearchInput') {
                    $newField->showSearchInput = true;
                } else {
                    $newField->{$attribute} = $oldField->{$attribute};
                }
            }

            if ($fieldsService->saveField($newField, false)) {
                $this->stdout('done.' . PHP_EOL);
            } else {
                $this->stderr('save failed.' . PHP_EOL, Console::FG_RED);
                $anyErrors = true;
            }
        }

        if ($anyErrors) {
            $this->stderr('Errors occurred while converting fields.' . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}
