<?php
namespace Craft;

/**
 * Class SuperCoolTools_DisabledPlainTextFieldType
 *
 * @package   SuperCoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

class SuperCoolTools_DisabledPlainTextFieldType extends BaseFieldType
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
		return Craft::t('Plain Text (disabled)');
	}

	/**
	 * @inheritDoc ISavableComponentType::getSettingsHtml()
	 *
	 * @return string|null
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('superCoolTools/fieldtypes/PlainText/settings', array(
			'settings' => $this->getSettings()
		));
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
		return craft()->templates->render('_includes/forms/text', array(
			'disabled' => true,
			'name'     => $name,
			'value'    => $value,
			'size'     => $this->getSettings()->size
		));
	}


	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseSavableComponentType::defineSettings()
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'size' => array(AttributeType::Number, 'default' => 20),
		);
	}

}
