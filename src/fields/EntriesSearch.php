<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\fields\Entries;
use craft\helpers\Template;
use spicyweb\oddsandends\assetbundles\tools\ToolsAsset;

/**
 * Entries Search Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class EntriesSearch extends Entries
{
    /**
     * @inheritdoc
     */
    protected string $inputTemplate = 'tools/_components/fields/entriessearch/input';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Entries (Search)');
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
