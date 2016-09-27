<?php

namespace Craft;

class SupercoolTools_AuthorInstructionsFieldType extends BaseFieldType
{
	/**
	 * Returns field type name
	 */
	public function getName()
	{
		return Craft::t('Author Instructions');
	}

	/**
	 * Define field type settings
	 */
	protected function defineSettings()
	{
		return array(
			'authorInstructions' => array( AttributeType::Mixed )
		);
	}

	/**
	 * Pass data to the settings template
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render( 'supercoolTools/fieldtypes/AuthorInstructions/settings',
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

		return craft()->templates->render( 'supercoolTools/fieldtypes/AuthorInstructions/input', array(
			'name'     => $name,
			'value'    => $value,
			'id'	   => $id,
			'settings' => $this->getSettings()
		));
	}
}