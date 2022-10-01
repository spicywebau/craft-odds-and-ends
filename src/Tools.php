<?php

namespace spicyweb\tools;

use Craft;
use craft\base\Model;
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
use spicyweb\tools\models\Settings;
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
    /**
     * @var Tools The plugin instance.
     */
    public static ?Tools $plugin = null;

    /**
     * @inheritdoc
     */
    public function init(): void
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

        // Register the Roll Your Own Widget
        Event::on(
            Dashboard::className(),
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = RollYourOwnWidget::class;
            }
        );

        Craft::info(Craft::t('tools', '{name} plugin loaded', ['name' => $this->name]), __METHOD__);
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }
}
