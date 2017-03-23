<?php
namespace Craft;

/**
 * Supercool Tools by Supercool
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolToolsPlugin extends BasePlugin
{

	public function getName()
	{
		return Craft::t('Tools');
	}

	public function getVersion()
	{
		return '1.10.0';
	}

	public function getSchemaVersion()
	{
		return '1.5.0';
	}

	public function getDeveloper()
	{
		return 'Supercool';
	}

	public function getDeveloperUrl()
	{
		return 'http://plugins.supercooldesign.co.uk';
	}

	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/supercool/Tools/master/changelog.json';
	}

	public function init()
	{
		Craft::import('plugins.supercooltools.tools.*');

		if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn() )
		{
			craft()->templates->includeCssResource('supercooltools/css/supercooltools.css');
			craft()->templates->includeJsResource('supercooltools/js/supercooltools.js');
		

			if (craft()->config->get('openInstructionLinksInNewWindow', 'SupercoolTools')) {
				craft()->templates->includeJs('new SupercoolTools.TargetBlankInstructionLinks();');
			}

		}
	}
}
