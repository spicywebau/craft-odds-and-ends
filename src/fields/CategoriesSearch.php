<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\fields\Categories;
use spicyweb\oddsandends\assetbundles\tools\ToolsAsset;

/**
 * Categories Search Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class CategoriesSearch extends Categories
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Categories (Search)');
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->inputTemplate = 'tools/_components/fields/categoriessearch/input';
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml($value, ElementInterface $element = null): string
    {
        Craft::$app->getView()->registerAssetBundle(ToolsAsset::class);
        return parent::inputHtml($value, $element);
    }
}
