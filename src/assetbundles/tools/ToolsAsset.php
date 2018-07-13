<?php
/**
 * TableMaker plugin for Craft CMS 3.x
 *
 * TableMaker
 *
 * @link      http://supercooldesig.co.uk
 * @copyright Copyright (c) 2017 Supercool
 */

namespace supercool\tools\assetbundles\tools;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * TablemakerFieldAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Supercool
 * @package   TableMaker
 * @since     1.0.0
 */
class ToolsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@supercool/tools/assetbundles/tools/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/nouislider.js',
            'js/tools.js',
        ];

        $this->css = [
            'css/nouislider.css',
            'css/nouislider.pips.css',
            'css/tools.css',
        ];

        parent::init();
    }
}
