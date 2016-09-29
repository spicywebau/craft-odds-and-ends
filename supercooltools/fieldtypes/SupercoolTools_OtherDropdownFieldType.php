<?php

namespace Craft;

/**
 * Class SupercoolTools_OtherDropdownFieldType
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_OtherDropdownFieldType extends DropdownFieldType
{
	/**
	 * Define name of the field type
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Dropdown (Other)');
	}

	/**
	 * Define field type settings
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		$settings = parent::defineSettings();
		$settings['otherLabel'] = array(AttributeType::String);
		return $settings;
	}

	/**
	 * Pass data to the settings template
	 *
	 * @return string
	 */
	public function getSettingsHtml()
	{
		$settingsHtml = parent::getSettingsHtml();
		return $settingsHtml . craft()->templates->render( 'supercoolTools/fieldtypes/OtherDropdown/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * Defines content type for the field type
	 *
	 * @return mixed
	 */
	public function defineContentAttribute()
    {
        return AttributeType::Mixed;
    }

    /**
     * Pass data to the field type input template
     * 
     * @param  $name
     * @param  $value
     * 
     * @return string
     */
	public function getInputHtml($name, $value)
	{
		$options = $this->getTranslatedOptions();

		// Add other option
		$options[] = ['label' => $this->settings->otherLabel, 'value' => 'other', 'default' => ''];

		// If this is a new entry, look for a default option
		if ($this->isFresh() || $value['dropdown'] == null )
		{
			$value['dropdown'] = $this->getDefaultValue();
		}

		return craft()->templates->render('supercoolTools/fieldtypes/OtherDropdown/input', array(
			'name'    => $name,
			'value'   => $value,
			'options' => $options
		));
	}

	/**
	 * Preparing value to be saved in the database
	 *
	 * @param  $value
	 * 
	 * @return string 
	 */
	public function prepValueFromPost($value)
	{
		if( $value['dropdown'] != "other" ) {
			$value['otherValue'] = "";
		}

		return $value;
	}

	/**
	 * Prepare values to be shown in the template
	 * 
	 * @param  $value
	 * 
	 * @return string
	 */
	public function prepValue($value)
	{
		$dropdown = $value['dropdown'];
		$dropdown = parent::prepValue($dropdown);
		
		$dropdown = $dropdown->__toString();

		$data = array(
			'dropdown' => $dropdown,
			'otherValue' => $value['otherValue']
		);		

		return $data;
	}

	/**
	 * Validate the value before it is saved to the database
	 * 
	 * @param  $value
	 * 
	 * @return boolean
	 */
	public function validate($value)
	{
		if( $value ) {
			if( $value['dropdown'] == "other" && $value['otherValue'] == "" ) {
				return Craft::t('{attribute} is invalid. It cannot be empty', array(
					'attribute' => Craft::t($this->model->name)
				));
			}
		}

		return true;
	}


}