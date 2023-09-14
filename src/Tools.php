<?php

namespace spicyweb\oddsandends;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Dashboard;
use craft\services\Fields;
use craft\services\Plugins;
use spicyweb\oddsandends\fields\Ancestors as AncestorsField;
use spicyweb\oddsandends\fields\AuthorInstructions as AuthorInstructionsField;
use spicyweb\oddsandends\fields\CategoriesMultipleGroups as CategoriesMultipleGroupsField;
use spicyweb\oddsandends\fields\CategoriesSearch as CategoriesSearchField;
use spicyweb\oddsandends\fields\DisabledCategories as DisabledCategoriesField;
use spicyweb\oddsandends\fields\DisabledDropdown as DisabledDropdownField;
use spicyweb\oddsandends\fields\DisabledEntries as DisabledEntriesField;
use spicyweb\oddsandends\fields\DisabledLightswitch as DisabledLightswitchField;
use spicyweb\oddsandends\fields\DisabledNumber as DisabledNumberField;
use spicyweb\oddsandends\fields\DisabledPlainText as DisabledPlainTextField;
use spicyweb\oddsandends\fields\DisabledProducts as DisabledProductsField;
use spicyweb\oddsandends\fields\DisabledUsers as DisabledUsersField;
use spicyweb\oddsandends\fields\DisabledVariants as DisabledVariantsField;
use spicyweb\oddsandends\fields\EntriesSearch as EntriesSearchField;
use spicyweb\oddsandends\fields\Grid as GridField;
use spicyweb\oddsandends\fields\ProductsSearch as ProductsSearchField;
use spicyweb\oddsandends\fields\VariantsSearch as VariantsSearchField;
use spicyweb\oddsandends\fields\Width as WidthField;
use spicyweb\oddsandends\models\Settings;
use spicyweb\oddsandends\widgets\RollYourOwn as RollYourOwnWidget;
use yii\base\Event;

/**
 * Class Tools
 *
 * @package spicyweb\oddsandends
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
    public string $minVersionRequired = '2.2.0';

    /**
     * @inheritdoc
     */
    public string $schemaVersion = '4.3.1';

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
                $enableNormalFields = [
                    AuthorInstructionsField::class,
                    DisabledLightswitchField::class,
                    DisabledPlainTextField::class,
                    DisabledNumberField::class,
                    DisabledEntriesField::class,
                    DisabledCategoriesField::class,
                    DisabledDropdownField::class,
                    DisabledUsersField::class,
                    EntriesSearchField::class,
                    CategoriesSearchField::class,
                    CategoriesMultipleGroupsField::class,
                    WidthField::class,
                    AncestorsField::class,
                    GridField::class,
                ];

                $enableNormalFields = array_diff($enableNormalFields, $this->settings->disableNormalFields);
                Craft::debug($this->name.' enable normal fields: ' . implode(', ', $enableNormalFields), __METHOD__);

                foreach ($enableNormalFields as $field) {
                    $event->types[] = $field;
                }

                $pluginsService = Craft::$app->getPlugins();
                if ($pluginsService->isPluginInstalled('commerce') && $pluginsService->isPluginEnabled('commerce')) {
                    $enableCommerceFields = [
                        DisabledProductsField::class,
                        DisabledVariantsField::class,
                        ProductsSearchField::class,
                        VariantsSearchField::class,
                    ];

                    $enableCommerceFields = array_diff($enableCommerceFields, $this->settings->disableCommerceFields);
                    Craft::debug($this->name.' enable commerce fields: ' . implode(', ', $enableCommerceFields), __METHOD__);

                    foreach ($enableCommerceFields as $field) {
                        $event->types[] = $field;
                    }
                }
            }
        );

        // Register widgets
        Event::on(
            Dashboard::className(),
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $enableWidgets = [
                    RollYourOwnWidget::class,
                ];

                $enableWidgets = array_diff($enableWidgets, $this->settings->disableWidgets);
                Craft::debug($this->name.' enable widgets: ' . implode(', ', $enableWidgets), __METHOD__);

                foreach ($enableWidgets as $widget) {
                    $event->types[] = $widget;
                }
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
