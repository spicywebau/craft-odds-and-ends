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
    protected string $inputTemplate = 'tools/_components/fields/categoriessearch/input';

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
    protected function inputHtml(mixed $value, ?ElementInterface $element = null, bool $inline = false): string
    {
        Craft::$app->getView()->registerAssetBundle(ToolsAsset::class);
        return parent::inputHtml($value, $element, $inline);
    }
}
