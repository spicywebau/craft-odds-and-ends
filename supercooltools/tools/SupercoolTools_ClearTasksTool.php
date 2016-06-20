<?php
namespace Craft;

/**
 * Class SupercoolTools_ClearTasksTool
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_ClearTasksTool extends BaseTool
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
		return Craft::t('Clear Tasks');
	}

	/**
	 * @inheritDoc ITool::getIconValue()
	 *
	 * @return string
	 */
	public function getIconValue()
	{
		return 'time';
	}

	/**
	 * @inheritDoc ITool::getButtonLabel()
	 *
	 * @return string
	 */
	public function getButtonLabel()
	{
		return Craft::t('Clear!');
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
		$tasks = craft()->tasks->getAllTasks();
		if (is_array($tasks))
		{
			foreach ($tasks as $task)
			{
				craft()->tasks->deleteTaskById($task->id);
			}
		}
	}

}
