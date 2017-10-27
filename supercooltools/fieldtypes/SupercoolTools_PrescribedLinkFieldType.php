<?php
namespace Craft;

/**
 * Class SupercoolTools_PrescribedLinkFieldType
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2017, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_PrescribedLinkFieldType extends BaseFieldType implements IPreviewableFieldType
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
		return Craft::t('Prescribed Link');
	}

	/**
	 * @inheritDoc ISavableComponentType::getSettingsHtml()
	 *
	 * @return string|null
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('supercoolTools/fieldtypes/PrescribedLink/settings', array(
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
		return craft()->templates->render('supercoolTools/fieldtypes/PrescribedLink/input', array(
			'disabled' => $this->getSettings()->disabled,
			'name'     => $name,
			'value'    => $value,
			'size'     => $this->getSettings()->size,
			'prescribedLink' => $this->getSettings()->prescribedLink,
			'prescribedLinkTitle' => $this->getSettings()->prescribedLinkTitle
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
			'prescribedLink' => array(AttributeType::String, 'required' => true),
			'prescribedLinkTitle' => array(AttributeType::String, 'required' => true),
			'disabled' => array(AttributeType::Bool)
		);
	}

}
