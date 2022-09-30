<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Lightswitch;
use yii\db\Schema;

/**
 * Disabled Lightswitch Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledLightswitch extends Lightswitch
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool Whether the lightswitch should be enabled by default
     */
    public bool $default = false;


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Lightswitch (Disabled)');
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
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_BOOLEAN;
    }

    /**
     * Normalizes the field’s value for use.
     *
     * @param mixed                 $value   The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return mixed The prepared field value
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        // If this is a new entry, look for a default option
        if ($value === null) {
            $value = $this->default;
        }
        
        return (bool)$value;
    }

    /**
     * Modifies an element query.
     *
     * @param ElementQueryInterface $query The element query
     * @param mixed                 $value The value that was set on this field’s corresponding [[ElementCriteriaModel]] param,
     *                                     if any.
     *
     * @return null|false `false` in the event that the method is sure that no elements are going to be found.
     */
    public function serializeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * Returns the component’s settings HTML.
     *
     * The same principles also apply if you’re including your JavaScript code with
     * [[\craft\web\View::registerJs()]].
     *
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {
        return parent::getSettingsHtml();
    }

    /**
     * Returns the field’s input HTML.
     *
     * @param mixed                 $value           The field’s value. This will either be the [[normalizeValue() normalized value]],
     *                                               raw POST data (i.e. if there was a validation error), or null
     * @param ElementInterface|null $element         The element the field is associated with, if there is one
     *
     * @return string The input HTML.
     */
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        // If this is a new entry, look for a default option
        if ($this->isFresh($element)) {
            $value = $this->default;
        }

        $id = Craft::$app->getView()->formatInputId($this->handle);

        return Craft::$app->getView()->renderTemplate('_includes/forms/lightswitch',
            [
                'id' => $id,
                'labelId' => $id . '-label',
                'name' => $this->handle,
                'on' => (bool)$value,
                'disabled' => true,
            ]);
    }
}
