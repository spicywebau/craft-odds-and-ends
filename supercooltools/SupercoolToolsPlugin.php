<?php
namespace Craft;

/**
 * Supercool Tools by Supercool
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolToolsPlugin extends BasePlugin
{

	public function getName()
	{
		return Craft::t('Supercool Tools');
	}

	public function getVersion()
	{
		return '1.4.2';
	}

	public function getDeveloper()
	{
		return 'Supercool';
	}

	public function getDeveloperUrl()
	{
		return 'http://plugins.supercooldesign.co.uk';
	}

	public function init()
	{
		if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn() )
		{
			craft()->templates->includeCssResource('supercooltools/css/supercooltools.css');
			craft()->templates->includeJsResource('supercooltools/js/supercooltools.js');
		}
	}

}
