<?php

namespace spicyweb\tools\fields;

use spicyweb\tools\Tools as ToolsPlugin;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Categories;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Template;

/**
 * Categories Search Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class CategoriesSearch extends Categories
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
        return Craft::t('tools', 'Categories (Search)');
    }

     // Public Methods
    // =========================================================================

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
