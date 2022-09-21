<?php

namespace spicyweb\tools\fields;

use spicyweb\tools\Tools as ToolsPlugin;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Entries;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;

/**
 * Disabled Entries Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledEntries extends Entries
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
    protected $inputTemplate = 'tools/_components/fields/elements/element-select';


    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Entries (Disabled)');
    }

}
