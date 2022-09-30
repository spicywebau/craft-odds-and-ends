<?php

namespace spicyweb\tools;

use Craft;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Dashboard;
use craft\services\Fields;
use craft\services\Plugins;
use spicyweb\tools\fields\Ancestors as AncestorsField;
use spicyweb\tools\fields\AuthorInstructions as AuthorInstructionsField;
use spicyweb\tools\fields\CategoriesMultipleGroups as CategoriesMultipleGroupsField;
use spicyweb\tools\fields\CategoriesSearch as CategoriesSearchField;
use spicyweb\tools\fields\DisabledCategories as DisabledCategoriesField;
use spicyweb\tools\fields\DisabledDropdown as DisabledDropdownField;

use spicyweb\tools\fields\DisabledEntries as DisabledEntriesField;

use spicyweb\tools\fields\DisabledLightswitch as DisabledLightswitchField;
use spicyweb\tools\fields\DisabledNumber as DisabledNumberField;
use spicyweb\tools\fields\DisabledPlainText as DisabledPlainTextField;
use spicyweb\tools\fields\EntriesSearch as EntriesSearchField;
use spicyweb\tools\fields\Grid as GridField;
use spicyweb\tools\fields\Width as WidthField;
use spicyweb\tools\widgets\RollYourOwn as RollYourOwnWidget;

use yii\base\Event;

/**
 * Class Tools
 *
 * @package spicyweb\tools
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class Tools extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Tools::$plugin
     *
     * @var Tools
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Tools::$plugin
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
            function(RegisterComponentTypesEvent $event) {
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
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = RollYourOwnWidget::class;
            }
        );

        // Do something after we're installed
        Event::on(
            Plugins::className(),
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function(PluginEvent $event) {
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
    protected function createSettingsModel(): ?\craft\base\Model
    {
        return new \spicyweb\tools\models\Settings();
    }
}
