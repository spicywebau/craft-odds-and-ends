<?php

namespace Craft;

class SupercoolTools_InstructionFieldType extends BaseFieldType
{
	/**
	 * Returns field type name
	 */
	public function getName()
	{
		return Craft::t('Instructor');
	}

	/**
	 * Define field type settings
	 */
	protected function defineSettings()
	{
		return array(
			'instructions' => array( AttributeType::Mixed )
		);
	}

	/**
	 * Pass data to the settings template
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render( 'supercoolTools/fieldtypes/Instruction/settings',
			array( 'settings' => $this->getSettings() )
		);
	}

	/**
	 * Pass data to the input template
	 */
	public function getInputHtml( $name, $value )
	{
		// Getting the namespaced id for the field
		$id =  craft()->templates->namespaceInputId( craft()->templates->formatInputId( $name ) );

		return craft()->templates->render( 'supercoolTools/fieldtypes/Instruction/input', array(
			'name'     => $name,
			'value'    => $value,
			'id'	   => $id,
			'settings' => $this->getSettings()
		));
	}
}