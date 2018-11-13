<?php
/**
 * SupercoolTools plugin for Craft CMS 3.x
 *
 * SupercoolTools
 *
 * @link      http://supercooldesign.co.uk
 * @copyright Copyright (c) 2017 Supercool
 */

namespace supercool\tools;

use supercool\tools\fields\AuthorInstructions as AuthorInstructionsField;
use supercool\tools\fields\DisabledLightswitch as DisabledLightswitchField;
use supercool\tools\fields\DisabledPlainText as DisabledPlainTextField;
use supercool\tools\fields\DisabledNumber as DisabledNumberField;
use supercool\tools\fields\DisabledEntries as DisabledEntriesField;
use supercool\tools\fields\DisabledCategories as DisabledCategoriesField;
use supercool\tools\fields\DisabledDropdown as DisabledDropdownField;
use supercool\tools\fields\EntriesSearch as EntriesSearchField;
use supercool\tools\fields\CategoriesSearch as CategoriesSearchField;
use supercool\tools\fields\CategoriesMultipleGroups as CategoriesMultipleGroupsField;
use supercool\tools\fields\Width as WidthField;
use supercool\tools\fields\Ancestors as AncestorsField;
use supercool\tools\fields\Grid as GridField;

use supercool\tools\widgets\RollYourOwn as RollYourOwnWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

class Tools extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * SupercoolTools::$plugin
     *
     * @var SupercoolTools
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * SupercoolTools::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our fields
        Event::on(
            Fields::className(),
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = AuthorInstructionsField::class;
                $event->types[] = DisabledLightswitchField::class;
                $event->types[] = DisabledPlainTextField::class;
                $event->types[] = DisabledNumberField::class;
                $event->types[] = DisabledEntriesField::class;
                $event->types[] = DisabledCategoriesField::class;
                $event->types[] = DisabledDropdownField::class;
                $event->types[] = EntriesSearchField::class;
                $event->types[] = CategoriesSearchField::class;
                $event->types[] = CategoriesMultipleGroupsField::class;
                $event->types[] = WidthField::class;
                $event->types[] = AncestorsField::class;
                $event->types[] = GridField::class;
            }
        );

        // Register our widgets
        Event::on(
            Dashboard::className(),
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = RollYourOwnWidget::class;
            }
        );

        // Do something after we're installed
        Event::on(
            Plugins::className(),
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(Craft::t('tools', '{name} plugin loaded', ['name' => $this->name]), __METHOD__);
    }

    // Protected Methods
    // =========================================================================

}
