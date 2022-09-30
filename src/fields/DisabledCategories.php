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
        return Craft::t('tools', 'Categories (Disabled)');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        $this->inputTemplate = 'tools/_components/fields/disabledcategories/input';
    }
}
