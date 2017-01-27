<?php
namespace Craft;

/**
 * SupercoolTools by Supercool
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @link      http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_SaveEventsTask extends BaseTask
{

	private $events;

	/**
	 * Returns the default description for this task.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return 'Saving all events';
	}

	/**
	 * Gets the total number of steps for this task.
	 *
	 * @return int
	 */
	public function getTotalSteps()
	{
		$this->events = craft()->elements->getCriteria('SuperCal_Event');
		$this->events->status = null;
		$this->events->limit = null;
		$this->events = $this->events->find();
		return count($this->events);
	}

	/**
	 * Runs a task step.
	 *
	 * @param int $step
	 * @return bool
	 */
	public function runStep($step)
	{

		$this->events[$step]->fresh = 0;
		$saved = craft()->superCal_events->saveEvent($this->events[$step]);
		if ( $saved )
		{
			return true;
		}
		else
		{
			SupercoolToolsPlugin::log("Error saving event: ". $this->events[$step]->title, LogLevel::Error, true);
			return false;
		}
	}

}
