<?php

namespace Craft;

/**
 * Class SupercoolTools_DefaultNumberFieldType
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DefaultNumberFieldType extends NumberFieldType
{

	/**
	 * Returns name of the field type
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t("Default Number");
	}


	/**
	 * Pass data to the settings template
	 *
	 * @return array
	 */
	public function getSettingsHtml()
	{
		$settingsHtml = parent::getSettingsHtml();

		return $settingsHtml . craft()->templates->render('supercoolTools/fieldtypes/DefaultNumber/settings', array(
            'settings' => $this->getSettings(),
        ));
	}

	/**
	 * Setting the default value
	 * @inheritDoc IFieldType::defineContentAttribute()
	 *
	 * @return mixed
	 */
	public function defineContentAttribute()
	{
		$attribute = ModelHelper::getNumberAttributeConfig($this->settings->min, $this->settings->max, $this->settings->decimals);
		$attribute['default'] = null;

		return $attribute;
	}

	/**
	 * Override the parent methods version of this so we don’t get the
	 * min value if its a fresh field
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		return craft()->templates->render('_includes/forms/text', array(
			'name'  => $name,
			'value' => craft()->numberFormatter->formatDecimal($value, false),
			'size'  => 5
		));
	}

	/**
	 * If value is null and not equals to 0 then set its value to default value
	 *
	 * @param  $value
	 *
	 * @return mixed
	 */
	public function prepValue($value)
	{

		if( $value == null && $value !== 0 ) {
			$value = $this->settings->defaultNumber;
		}

		return $value;
	}


	/**
	 * Creating an instance of Default Number FieldTypeSettings Model
	 *
	 * @return BaseModel
	 */
	protected function getSettingsModel()
	{
		return new SupercoolTools_DefaultNumberFieldTypeSettingsModel();
	}

}
