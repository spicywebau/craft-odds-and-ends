<?php
namespace Craft;

/**
 * Class SupercoolTools_DisabledLightswitchFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DisabledLightswitchFieldType extends LightswitchFieldType implements IPreviewableFieldType
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
		return Craft::t('Lightswitch (disabled)');
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
		// If this is a new entry, look for a default option
		if ($this->isFresh())
		{
			$value = $this->getSettings()->default;
		}

		return craft()->templates->render('_includes/forms/lightswitch', array(
			'name'     => $name,
			'on'       => (bool) $value,
			'disabled' => true
		));
	}

}
