<?php
namespace Craft;

/**
 * Clear Caches tool.
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2014, Pixel & Tonic, Inc.
 * @license   http://craftcms.com/license Craft License Agreement
 * @see       http://craftcms.com
 * @package   craft.app.tools
 * @since     1.0
 */
class SupercoolTools_ClearCachesTool extends BaseTool
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
		return Craft::t('Clear Caches');
	}

	/**
	 * @inheritDoc ITool::getIconValue()
	 *
	 * @return string
	 */
	public function getIconValue()
	{
		return 'trash';
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
		craft()->templateCache->deleteAllCaches();
	}

	// Private Methods
	// =========================================================================

	/**
	 * Returns the cache folders we allow to be cleared as well as any plugin cache paths that have used the
	 * 'registerCachePaths' hook.
	 *
	 * @param bool $obfuscate If true, will MD5 the path so it will be obfuscated in the template.
	 *
	 * @return array
	 */
	private function _getFolders($obfuscate = true)
	{
		$runtimePath = craft()->path->getRuntimePath();

		$folders = array(
			$obfuscate ? md5('dataCache') : 'dataCache'                                             => Craft::t('Data caches'),
			$obfuscate ? md5($runtimePath.'cache') : $runtimePath.'cache'                           => Craft::t('RSS caches'),
			$obfuscate ? md5($runtimePath.'assets') : $runtimePath.'assets'                         => Craft::t('Asset caches'),
			$obfuscate ? md5($runtimePath.'compiled_templates') : $runtimePath.'compiled_templates' => Craft::t('Compiled templates'),
			$obfuscate ? md5($runtimePath.'temp') : $runtimePath.'temp'                             => Craft::t('Temp files'),
		);

		$pluginCachePaths = craft()->plugins->call('registerCachePaths');

		if (is_array($pluginCachePaths) && count($pluginCachePaths) > 0)
		{
			foreach ($pluginCachePaths as $paths)
			{
				foreach ($paths as $path => $label)
				{
					$folders[$obfuscate ? md5($path) : $path] = $label;
				}
			}
		}

		return $folders;
	}
}
