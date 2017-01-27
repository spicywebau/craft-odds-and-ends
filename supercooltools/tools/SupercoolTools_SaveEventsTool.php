<?php
namespace Craft;

/**
 * Class SupercoolTools_SaveEventsTool
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_SaveEventsTool extends BaseTool
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
		return Craft::t('Save Events');
	}

	/**
	 * @inheritDoc ITool::getIconValue()
	 *
	 * @return string
	 */
	public function getIconValue()
	{
		return 'date';
	}

	/**
	 * @inheritDoc ITool::getButtonLabel()
	 *
	 * @return string
	 */
	public function getButtonLabel()
	{
		return Craft::t('Save all events');
	}

	/**
	 * @inheritDoc ITool::performAction()
	 *
	 * @param array $params
	 *
	 * @return null
	 */
	public function performAction($params = array())
	{
		craft()->tasks->createTask('SupercoolTools_SaveEvents');
	}

}
