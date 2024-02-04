<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Number;
use craft\i18n\Locale;

/**
 * Disabled Number Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledNumber extends Number
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Number (Disabled)');
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        if ($value == null && $this->defaultValue !== null) {
            $value = $this->defaultValue;
        }
        
        return parent::normalizeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null, bool $inline = false): string
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
