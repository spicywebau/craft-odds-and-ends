<?php
namespace Craft;

/**
 * Class SupercoolTools_CategoriesMultipleGroupsFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_CategoriesMultipleGroupsFieldType extends CategoriesFieldType
{

	// Properties
	// =========================================================================

	/**
	 * The element type this field deals with.
	 *
	 * @var string $elementType
	 */
	protected $elementType = 'Category';

	/**
	 * Whether to allow multiple source selection in the settings.
	 *
	 * @var bool $allowMultipleSources
	 */
	protected $allowMultipleSources = true;

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Categories (multiple groups)');
	}


	/**
	 * @inheritDoc IFieldType::getInputHtml()
	 *
	 * @param string $name
	 * @param mixed  $criteria
	 *
	 * @return string
	 */
	public function getInputHtml($name, $criteria)
	{
		return BaseElementFieldType::getInputHtml($name, $criteria);
	}


	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseElementFieldType::getAddButtonLabel()
	 *
	 * @return string
	 */
	protected function getAddButtonLabel()
	{
		return Craft::t('Add a category');
	}

}
