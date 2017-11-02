<?php
namespace Craft;

/**
 * Class SupercoolTools_CategoriesSearchMultipleGroupsFieldType
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2017, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_CategoriesSearchMultipleGroupsFieldType extends CategoriesFieldType implements IPreviewableFieldType
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
		return Craft::t('Categories (search multiple groups)');
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

		$sources = $this->getSettings()->sources;

		if (empty($sources))
		{
			return '<p class="error">'.Craft::t('This field is not set to a valid category group.').'</p>';
		}

		// Get template variable which we will pass to input template
		$variables = $this->getInputTemplateVariables($name, $criteria);


		// If sources is set to all ('*') then get all group ids and build sources array
		// This fixes the issue of category groups not being separated (grouped) when searching for
		// in field
		if ( $sources == "*" )
		{
			$groups = craft()->categories->getAllGroupIds();
			foreach ($groups as $group) {
				$buildSources[] = 'group:'.$group;
			}

			$variables['sources'] = $buildSources;
		}

		return craft()->templates->render('supercoolTools/fieldtypes/CategoriesMultipleSearch/input', $variables);
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
