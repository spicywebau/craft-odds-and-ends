<?php
namespace Craft;

/**
 * Class SupercoolToolsController
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolToolsController extends BaseController
{

	protected $allowAnonymous = array('actionDownloadFile');

	/**
	 * Downloads a file
	 */
	public function actionDownloadFile()
	{

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