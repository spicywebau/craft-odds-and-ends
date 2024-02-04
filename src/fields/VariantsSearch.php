<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\commerce\fields\Variants;
use craft\helpers\Template;
use spicyweb\oddsandends\assetbundles\tools\ToolsAsset;

/**
 * Commerce Variants Search Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @since 4.1.0
 */
class VariantsSearch extends Variants
{
    /**
     * @inheritdoc
     */
    protected string $inputTemplate = 'tools/_components/fields/variantssearch/input';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Commerce Variants (Search)');
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
