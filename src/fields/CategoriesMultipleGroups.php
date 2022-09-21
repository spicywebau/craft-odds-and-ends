<?php

namespace spicyweb\tools\fields;

use spicyweb\tools\Tools as ToolsPlugin;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Categories;
use craft\fields\BaseRelationField;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Template;

/**
 * Categories Multiple Groups Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class CategoriesMultipleGroups extends Categories
{
    // Public Properties
    // =========================================================================


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Categories (Multiple Groups)');
    }

     // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->allowMultipleSources = true;
    }

     /**
     * @inheritdoc
     */
    public function inputHtml($value, ElementInterface $element = null): string
    {
        return BaseRelationField::inputHtml($value, $element);
    }


}
