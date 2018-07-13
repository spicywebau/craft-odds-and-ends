<?php
/**
 * SupercoolTools plugin for Craft CMS 3.x
 *
 * SupercoolTools
 *
 * @link      http://supercooldesign.co.uk
 * @copyright Copyright (c) 2017 Supercool
 */

namespace supercool\tools\fields;

use supercool\tools\Tools as ToolsPlugin;
use supercool\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Entries;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;

/**
 * Entries Search Field
 *
 * @author    Supercool
 * @package   SupercoolTools
 * @since     1.0.0
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
    protected $inputTemplate = 'tools/_components/fields/entriessearch/input';


    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Entries (Search)');
    }

}
