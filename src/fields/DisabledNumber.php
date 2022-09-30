<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Number;
use craft\i18n\Locale;

/**
 * Disabled Number Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledNumber extends Number
{
    // Public Properties
    // =========================================================================

    /**
     * @var int|float|null The default value for new elements
     */
    public int|float|null $defaultValue = null;

    /**
     * @var int|float The minimum allowed number
     */
    public int|float|null $min = 0;

    /**
     * @var int|float|null The maximum allowed number
     */
    public int|float|null $max = null;

    /**
     * @var int The number of digits allowed after the decimal point
     */
    public int $decimals = 0;

    /**
     * @var int|null The size of the field
     */
    public ?int $size = null;


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Number (Disabled)');
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
     * Normalizes the field’s value for use.
     *
     * @param mixed                 $value   The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return mixed The prepared field value
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        if ($value == null && $this->defaultValue !== null) {
            $value = $this->defaultValue;
        }
        
        return parent::normalizeValue($value, $element);
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
        // If decimals is 0 (or null, empty for whatever reason), don't run this
        if ($value !== null && $this->decimals) {
            $decimalSeparator = Craft::$app->getLocale()->getNumberSymbol(Locale::SYMBOL_DECIMAL_SEPARATOR);
            try {
                $value = number_format($value, $this->decimals, $decimalSeparator, '');
            } catch (\Throwable $e) {
                // NaN
            }
        }

        return Craft::$app->getView()->renderTemplate('_includes/forms/text', [
            'name' => $this->handle,
            'value' => $value,
            'size' => $this->size,
            'disabled' => true,
        ]);
    }
}
