<?php
namespace Craft;

/**
 * Class SupercoolToolsController
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolToolsController extends BaseController
{

	protected $allowAnonymous = array('actionDownloadFile','actionClearCache');


	/**
	 * Shows the Tools index template
	 */
	public function actionToolsIndex()
	{
		// Get only the tools we want
		$tools = array(
			'SupercoolTools_ClearCaches' => craft()->components->getComponentByTypeAndClass(ComponentType::Tool, 'SupercoolTools_ClearCaches'),
			'SupercoolTools_ClearTasks' => craft()->components->getComponentByTypeAndClass(ComponentType::Tool, 'SupercoolTools_ClearTasks'),
			'SearchIndex' => craft()->components->getComponentByTypeAndClass(ComponentType::Tool, 'SearchIndex')
		);

		// Check supercal plugin is enabled
		// if yes then add save events tool
		$plugin = craft()->plugins->getPlugin('superCal', false);
		if ( $plugin->isEnabled )
		{
			$tools['SupercoolTools_SaveEvents'] = craft()->components->getComponentByTypeAndClass(ComponentType::Tool, 'SupercoolTools_SaveEvents');
		}

		$variables['tools'] = ToolVariable::populateVariables($tools);

		$this->renderTemplate('supercooltools/_index', $variables);
	}

	/**
	 * Downloads a file and cleans up old temporary assets
	 */
	public function actionDownloadFile()
	{

		// Clean up temp assets files that are more than a day old
		$fileResults = array();

		$files = IOHelper::getFiles(craft()->path->getTempPath(), true);

		foreach ($files as $file)
		{
			$lastModifiedTime = IOHelper::getLastTimeModified($file, true);
			if (substr(IOHelper::getFileName($file, false, true), 0, 6) === "assets" && DateTimeHelper::currentTimeStamp() - $lastModifiedTime->getTimestamp() >= 86400)
			{
				IOHelper::deleteFile($file);
			}
		}

		// Sort out the file we want to download
		$id = craft()->request->getParam('id');

		$criteria = craft()->elements->getCriteria(ElementType::Asset);
		$criteria->id = $id;
		$asset = $criteria->first();

		if ($asset)
		{

			// Get a local copy of the file
			$sourceType = craft()->assetSources->getSourceTypeById($asset->sourceId);
			$localCopy = $sourceType->getLocalCopy($asset);

			// Send it to the browser
			craft()->request->sendFile($asset->filename, IOHelper::getFileContents($localCopy), array('forceDownload' => true));
			craft()->end();

		}

	}

	/**
	 * Clear the cache
	 */
	public function actionClearCache()
	{

		// Delete all the template caches!
		craft()->templateCache->deleteAllCaches();

		// Run any pending tasks
		if (!craft()->tasks->isTaskRunning())
		{
			// Is there a pending task?
			$task = craft()->tasks->getNextPendingTask();

			if ($task)
			{
				// Attempt to close the connection if this is an Ajax request
				if (craft()->request->isAjaxRequest())
				{
					craft()->request->close();
				}

				// Start running tasks
				craft()->tasks->runPendingTasks();
			}
		}

		// Exit
		craft()->end();

	}

	/**
	 * Fork of tags/searchForTags adjusted to cope with any element
	 */
	public function actionSearchForElements()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$search = craft()->request->getPost('search');
		$excludeIds = craft()->request->getPost('excludeIds', array());

		// Get the post data
		$elementType = craft()->request->getPost('elementType');
		$sources = craft()->request->getPost('sources');

		// Deal with Entries
		if ($elementType == ElementType::Entry)
		{
			// Start the criteria
			$criteria = craft()->elements->getCriteria(ElementType::Entry);

			// Fangle the sections out of the sources
			$sections = array();
			if (is_array($sources))
			{

				foreach ($sources as $source)
				{
					switch ($source)
					{
						case 'singles':
						{
							$sections = array_merge($sections, craft()->sections->getSectionsByType(SectionType::Single));
							break;
						}
						default:
						{
							if (preg_match('/^section:(\d+)$/', $source, $matches))
							{
								$section = craft()->sections->getSectionById($matches[1]);

								if ($section)
								{
									$sections = array_merge($sections, array($section));
								}
							}
						}
					}
				}

			}

			$criteria->section = $sections;

		}
		// Deal with Categories
		else if ($elementType == ElementType::Category)
		{
			// Start the criteria
			$criteria = craft()->elements->getCriteria(ElementType::Category);
		}

		// Add and exclude ids
		$notIds = array('and');

		foreach ($excludeIds as $id)
		{
			$notIds[] = 'not '.$id;
		}

		// Set the rest of the criteria
		$criteria->title   = '*'.DbHelper::escapeParam($search).'*';
		$criteria->id      = $notIds;
		$criteria->status  = null;
		$criteria->limit   = 20;
		$elements = $criteria->find();

		$return = array();
		$exactMatches = array();
		$exactMatch = false;

		$normalizedSearch = StringHelper::normalizeKeywords($search);

		foreach ($elements as $element)
		{
			if ($elementType == ElementType::Entry)
			{
				if (!is_array($sources))
				{
					$sourceKey = "*";
				}
				else if ($element->section->type == SectionType::Single)
				{
					$sourceKey = "singles";
				}
				else
				{
					$sourceKey = "section:".$element->section->id;
				}

				$return[$sourceKey][] = array(
					'id'          => $element->id,
					'title'       => $element->getContent()->title,
					'status'      => $element->status,
					'sourceName'  => $element->section->name
				);
			}
			else if ($elementType == ElementType::Category)
			{
				$sourceKey = "group:".$element->group->id;
				$return[$sourceKey][] = array(
					'id'          => $element->id,
					'title'       => $element->getContent()->title,
					'status'      => $element->status,
					'sourceName'  => $element->group->name
				);
			}

			$normalizedTitle = StringHelper::normalizeKeywords($element->getContent()->title);

			if ($normalizedTitle == $normalizedSearch)
			{
				$exactMatches[] = 1;
				$exactMatch = true;
			}
			else
			{
				$exactMatches[] = 0;
			}
		}

		// NOTE: We’ve lost the sorting by exact match
		// array_multisort($exactMatches, SORT_DESC, $return);

		$this->returnJson(array(
			'elements'   => $return,
			'exactMatch' => $exactMatch
		));
	}

}
