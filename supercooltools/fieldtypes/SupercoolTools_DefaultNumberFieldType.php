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
		$attribute['default'] = $this->settings->defaultNumber;

		return $attribute;
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