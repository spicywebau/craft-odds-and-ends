<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\fields\Categories;

/**
 * Disabled Categories Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledCategories extends Categories
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Categories (Disabled)');
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->inputTemplate = 'tools/_components/fields/disabledcategories/input';
    }
}
