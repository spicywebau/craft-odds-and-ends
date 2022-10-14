<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\BaseRelationField;
use craft\fields\Categories;

/**
 * Categories Multiple Groups Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class CategoriesMultipleGroups extends Categories
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Categories (Multiple Groups)');
    }

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
