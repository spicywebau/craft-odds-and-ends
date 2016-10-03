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
		return Craft::t('Dropdown (other)');
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
		$settings['otherPlaceholder'] = array(AttributeType::String);
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

		// Setting the Other label
		$otherLabel = $this->settings->otherLabel;

		if( $otherLabel == "" )
		{
			$otherLabel = "Other";
		}

		// Add the other option
		$options[] = ['label' => $otherLabel, 'value' => 'other', 'default' => ''];

		// If this is a new entry, look for a default option
		if ($this->isFresh() || $value->__toString() == null )
		{
			$value->value = $this->getDefaultValue();
		}

		return craft()->templates->render('supercoolTools/fieldtypes/OtherDropdown/input', array(
			'name'    => $name,
			'value'   => $value,
			'options' => $options,
			'settings' => $this->getSettings()
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
		$selectedValues = ArrayHelper::stringToArray($value);

		// Setting the label for selected value
		$label = $this->getOptionLabel($value['dropdown']);

		if( $label == "other" )
		{
			$label = $this->settings->otherLabel;
		}

		$value = new OtherDropdownData($label, $value['dropdown'], $value['otherValue'], true);

		$options = array();

		foreach ($this->getOptions() as $option)
		{
			$selected = in_array($option['value'], $selectedValues);
			$options[] = new OtherDropdownData($option['label'], $option['value'], null, $selected);
		}

		// Add other in the options
		$selected = in_array('other', $selectedValues);
		$options[] = new OtherDropdownData($this->settings->otherLabel, 'other', $value->otherValue, $selected);

		// Set all the options
		$value->setOptions($options);

		return $value;
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
				return Craft::t('{attribute} is invalid. You have selected {selected} but not entered a value.', array(
					'attribute' => Craft::t($this->model->name),
					'selected' => Craft::t($this->model->settings['otherLabel']),
				));
			}
		}

		return true;
	}


}
