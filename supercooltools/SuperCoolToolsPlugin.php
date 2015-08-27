<?php
namespace Craft;

/**
 * Super Cool Tools by Supercool
 *
 * @package   SuperCoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

class SuperCoolToolsPlugin extends BasePlugin
{

	public function getName()
	{
		return Craft::t('Super Cool Tools');
	}

	public function getVersion()
	{
		return '1.0';
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
			craft()->templates->includeCssResource('superCoolTools/css/supercooltools.css');
			craft()->templates->includeJsResource('superCoolTools/js/supercooltools.js');
		}
	}

}
