<?php
namespace Craft;

/**
 * Class SupercoolTools_DisabledDropdownFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DisabledDropdownFieldType extends DropdownFieldType
{

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Dropdown (disabled)');
	}

	/**
	 * @inheritDoc IFieldType::getInputHtml()
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$options = $this->getTranslatedOptions();

		// If this is a new entry, look for a default option
		if ($this->isFresh())
		{
			$value = $this->getDefaultValue();
		}

		return craft()->templates->render('_includes/forms/select', array(
			'name'     => $name,
			'value'    => $value,
			'options'  => $options,
			'disabled' => true,
			'class' => 'disabled'
		));
	}

}
