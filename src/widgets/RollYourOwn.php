<?php

namespace spicyweb\tools\widgets;

use Craft;
use craft\base\Widget;

/**
 * Roll Your Own Widget
 *
 * @package spicyweb\tools\widgets
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class RollYourOwn extends Widget
{
    // Public Properties
    // =========================================================================

    /**
     * @var string|null
     */
    public ?string $title = null;

    public string $template = "_dashboard";

    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Roll Your Own');
    }

    /**
     * Returns the path to the widget’s SVG icon.
     *
     * @return string|null The path to the widget’s SVG icon
     */
    public static function iconPath(): ?string
    {
        return null;
    }

    /**
     * Returns the widget’s maximum colspan.
     *
     * @return int|null The widget’s maximum colspan, if it has one
     */
    public static function maxColspan(): ?int
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * Returns the component’s settings HTML.
     *
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'tools/_components/widgets/rollyourown/settings',
            [
                'widget' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): ?string
    {
        return $this->title ? Craft::t('site', $this->title) : static::displayName();
    }

    /**
     * Returns the widget's body HTML.
     *
     * @return string|false The widget’s body HTML, or `false` if the widget
     *                      should not be visible. (If you don’t want the widget
     *                      to be selectable in the first place, use {@link isSelectable()}.)
     */
    public function getBodyHtml(): ?string
    {
        $oldMode = Craft::$app->getView()->getTemplateMode();
        Craft::$app->getView()->setTemplateMode('site');

        $output = Craft::$app->getView()->renderTemplate($this->template);

        Craft::$app->getView()->setTemplateMode($oldMode);

        return $output;
    }
}
