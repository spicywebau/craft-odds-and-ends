<?php

namespace Craft;

/**
 * Class SupercoolTools_WidthFieldType
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_WidthFieldType extends DropdownFieldType
{
	/**
	 * Define name of the field type
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Width');
	}

	/**
	 * Define field type settings
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		$settings = parent::defineSettings();
		return $settings;
	}

	/**
	 * @inheritDoc BaseElementFieldType::getSettingsHtml()
	 *
	 * @return string|null
	 */
	public function getSettingsHtml()
	{
		$options = $this->getOptions();

		if (!$options)
		{
			// Give it a default row
			$options = array(array('label' => '', 'value' => ''));
		}

		return craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => $this->getOptionsSettingsLabel(),
				'instructions' => Craft::t('Define the available options.'),
				'id'           => 'options',
				'name'         => 'options',
				'addRowLabel'  => Craft::t('Add an option'),
				'cols'         => array(
					'widthValue' => array(
						'heading'      => Craft::t('Width Value'),
						'type'         => 'singleline',
						'class'        => 'code'
					),
					'widthDefault' => array(
						'heading'      => Craft::t('Width Default?'),
						'type'         => 'checkbox',
						'class'        => 'thin'
					),

					'leftValue' => array(
						'heading'      => Craft::t('Left Value'),
						'type'         => 'singleline',
						'class'        => 'code'
					),
					'leftDefault' => array(
						'heading'      => Craft::t('Left Default?'),
						'type'         => 'checkbox',
						'class'        => 'thin'
					),

					'rightValue' => array(
						'heading'      => Craft::t('Right Value'),
						'type'         => 'singleline',
						'class'        => 'code'
					),
					'rightDefault' => array(
						'heading'      => Craft::t('Right Default?'),
						'type'         => 'checkbox',
						'class'        => 'thin'
					),
				),
				'rows' => $options
			)
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
		//$options = $this->getTranslatedOptions();
		
		$id = craft()->templates->namespaceInputId( craft()->templates->formatInputId($name) );

		return craft()->templates->render( 'SupercoolTools/fieldtypes/Width/input', array(
			'name' => $name,
			'value' => $value,
			'namespaceId' => $id
		));
	}

	/**
	 * Prepare values for use
	 */
	public function prepValue($value)
	{
		$options = $this->getOptions();

		$data = new WidthData();

		return $data->setData($options, $value);
	}

	/**
	 * Validate data
	 */
	public function validate($value)
	{
		return true;
	}

    /**
	 * @inheritDoc BaseOptionsFieldType::getOptionsSettingsLabel()
	 *
	 * @return string
	 */
	protected function getOptionsSettingsLabel()
	{
		return Craft::t('Width Options');
	}

	protected function getOptionLabel($value)
	{
		return "";
	}


}