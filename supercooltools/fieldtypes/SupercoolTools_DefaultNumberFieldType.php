<?php

namespace Craft;

/**
 * Class SupercoolTools_DefaultNumberFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DefaultNumberFieldType extends NumberFieldType
{

	/**
	 * Returns name of the field type
	 * 
	 * @return String
	 */
	public function getName()
	{
		return Craft::t("Default Number");
	}
	

	/**
	 * Pass data to the settings template
	 */
	public function getSettingsHtml()
	{
		$settingsHtml = parent::getSettingsHtml();

		return $settingsHtml . craft()->templates->render('supercoolTools/fieldtypes/DefaultNumber/settings', array(
            'settings' => $this->getSettings(),
        ));
	}


	/**
	 * Pass data to input template
	 */
	public function getInputHtml($name, $value)
	{
		if( $this->isFresh() && $this->settings->defaultNumber )
		{
			$value = $this->settings->defaultNumber;
		}
		elseif ($this->isFresh() && ($value < $this->settings->min || $value > $this->settings->max))
		{
			$value = $this->settings->min;
		}

		return craft()->templates->render('_includes/forms/text', array(
			'name'  => $name,
			'value' => craft()->numberFormatter->formatDecimal($value, false),
			'size'  => 5
		));
	}

	/**
	 * Creating an instance of Default Number FieldTypeSettings Model
	 */
	protected function getSettingsModel()
	{
		return new SupercoolTools_DefaultNumberFieldTypeSettingsModel();
	}

}