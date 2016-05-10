<?php
namespace Craft;

/**
 * Class SupercoolTools_RollYourOwnWidget
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_RollYourOwnWidget extends BaseWidget
{

	// Properties
	// =========================================================================

	/**
	 * @var bool
	 */
	public $multipleInstances = true;


	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Roll Your Own');
	}

	/**
	 * @inheritDoc IWidget::getTitle()
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getSettings()->title;
	}

	/**
	 * @inheritDoc IWidget::getBodyHtml()
	 *
	 * @return string|false
	 */
	public function getBodyHtml()
	{
		$oldMode = craft()->templates->getTemplateMode();
		craft()->templates->setTemplateMode(TemplateMode::Site);

		$output = craft()->templates->render($this->getSettings()->template);

		craft()->templates->setTemplateMode($oldMode);

		return $output;
	}

	/**
	 * @inheritDoc ISavableComponentType::getSettingsHtml()
	 *
	 * @return string
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('supercoolTools/widgets/RollYourOwn/settings', array(
			'settings' => $this->getSettings()
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
			'title' => array(AttributeType::String, 'required' => true),
			'template' => array(AttributeType::Template, 'required' => true),
		);
	}

}
