<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\commerce\fields\Products;
use craft\helpers\Template;
use spicyweb\oddsandends\assetbundles\tools\ToolsAsset;

/**
 * Commerce Products Search Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 4.1.0
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    protected string $inputTemplate = 'tools/_components/fields/productssearch/input';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Commerce Products (Search)');
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        Craft::$app->getView()->registerAssetBundle(ToolsAsset::class);
        return parent::inputHtml($value, $element);
    }
}
