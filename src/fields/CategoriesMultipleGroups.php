<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\BaseRelationField;
use craft\fields\Categories;

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
    public function init(): void
    {
        parent::init();
        $this->allowMultipleSources = true;
    }

    /**
    * @inheritdoc
    */
    public function inputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        return BaseRelationField::inputHtml($value, $element);
    }
}
