<?php

namespace spicyweb\tools\fields;

use Craft;

use craft\base\ElementInterface;
use craft\fields\Entries;
use craft\helpers\Template;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

/**
 * Entries Search Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class EntriesSearch extends Entries
{
    // Public Properties
    // =========================================================================


    // Static Methods
    // =========================================================================

    /**
     * Template to use for field rendering
     *
     * @var string
     */
    protected string $inputTemplate = 'tools/_components/fields/entriessearch/input';


    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Entries (Search)');
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ElementInterface $element = null): string
    {
        Craft::$app->getView()->registerAssetBundle(ToolsAsset::class);
        return parent::inputHtml($value, $element);
    }
}
