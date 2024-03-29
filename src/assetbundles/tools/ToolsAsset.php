<?php

namespace spicyweb\oddsandends\assetbundles\tools;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Class ToolsAsset
 *
 * @package spicyweb\oddsandends\assetbundles\tools
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class ToolsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@spicyweb/oddsandends/assetbundles/tools/dist";

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
