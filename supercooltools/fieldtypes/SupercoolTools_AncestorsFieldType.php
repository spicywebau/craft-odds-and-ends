<?php
namespace Craft;

/**
 * Class SupercoolTools_AncestorsFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_AncestorsFieldType extends BaseElementFieldType
{

	// Properties
	// =========================================================================

	/**
	 * The element type this field deals with.
	 *
	 * @var string $elementType
	 */
	protected $elementType = 'Entry';

	/**
	 * Whether to allow multiple source selection in the settings.
	 *
	 * @var bool $allowMultipleSources
	 */
	protected $allowMultipleSources = false;

	/**
	 * Whether to allow the Limit setting.
	 *
	 * @var bool $allowLimit
	 */
	protected $allowLimit = true;

	/**
	 * Template to use for field rendering.
	 *
	 * @var string
	 */
	protected $inputTemplate = 'supercoolTools/fieldtypes/Ancestors/input';


	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Ancestors');
	}

	/**
	 * @inheritDoc ISavableComponentType::getSettingsHtml()
	 *
	 * @return string|null
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('supercoolTools/fieldtypes/Ancestors/settings', array(
			'allowLimit'           => $this->allowLimit,
			'targetLocaleField'    => $this->getTargetLocaleFieldHtml(),
			'settings'             => $this->getSettings(),
			'type'                 => $this->getName()
		));
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
		$variables = $this->getInputTemplateVariables($name, $criteria);

		return craft()->templates->render($this->inputTemplate, $variables);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * Returns an array of the source keys the field should be able to select elements from.
	 *
	 * @return array
	 */
	protected function getInputSources()
	{
		$sources = array('section:'.$this->element->section->id);

		return $sources;
	}

	/**
	 * Returns any additional criteria parameters limiting which elements the field should be able to select.
	 *
	 * @return array
	 */
	protected function getInputSelectionCriteria()
	{

		// Return the current elements ancestors, if there are any
		$ids = $this->element->getAncestors()->ids();

		if (count($ids))
		{
			return array(
				'id' => $ids
			);
		}

		// If there is a parent id param then its a new child entry
		$parentId = craft()->request->getParam('parentId');
		$ids = array();
		if ($parentId)
		{
			$parent = craft()->elements->getElementById($parentId);
			$ids[] = $parent->id;

			$criteria = craft()->elements->getCriteria($this->elementType);
			$criteria->ancestorOf = $parent->id;
			$criteria->locale     = $parent->locale;

			return array(
				'id' => array_merge($ids, $criteria->ids())
			);
		}

		// Fallback to nothing
		return array();

	}

}
