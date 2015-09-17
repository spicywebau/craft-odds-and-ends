<?php
namespace Craft;

/**
 * Class SupercoolToolsController
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
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
	 * Fork of tags/searchForTags adjusted to cope with Entries
	 */
	public function actionSearchForEntries()
	{
		$this->requirePostRequest();
		$this->requireAjaxRequest();

		$search = craft()->request->getPost('search');
		$excludeIds = craft()->request->getPost('excludeIds', array());


		// Fangle the sources out of the field settings
		$sources = craft()->request->getPost('sources');
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

		$notIds = array('and');

		foreach ($excludeIds as $id)
		{
			$notIds[] = 'not '.$id;
		}

		$criteria = craft()->elements->getCriteria(ElementType::Entry);
		$criteria->section = $sections;
		$criteria->title   = '*'.DbHelper::escapeParam($search).'*';
		$criteria->id      = $notIds;
		$criteria->status  = null;
		$criteria->limit   = 20;
		$entries = $criteria->find();

		$return = array();
		$exactMatches = array();
		$exactMatch = false;

		$normalizedSearch = StringHelper::normalizeKeywords($search);

		foreach ($entries as $entry)
		{
			if (!is_array($sources))
			{
				$sectionKey = "*";
			}
			else if ($entry->section->type == SectionType::Single)
			{
				$sectionKey = "singles";
			}
			else
			{
				$sectionKey = "section:".$entry->section->id;
			}

			$return[$sectionKey][] = array(
				'id'          => $entry->id,
				'title'       => $entry->getContent()->title,
				'status'      => $entry->status,
				'sectionName' => $entry->section->name
			);

			$normalizedTitle = StringHelper::normalizeKeywords($entry->getContent()->title);

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
			'entries'    => $return,
			'exactMatch' => $exactMatch
		));
	}

}
