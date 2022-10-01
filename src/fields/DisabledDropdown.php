<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Dropdown;

/**
 * Disabled Dropdown Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledDropdown extends Dropdown
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Dropdown (Disabled)');
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value == null) {
            $value = $this->defaultValue();
        }

        return parent::normalizeValue($value, $element);
    }


    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $options = $this->translatedOptions();

        // If this is a new entry, look for a default option
        if ($this->isFresh($element)) {
            $value = $this->defaultValue();
        }

        return Craft::$app->getView()->renderTemplate('_includes/forms/select',
            [
                'name' => $this->handle,
                'value' => $value,
                'options' => $options,
                'disabled' => true,
                'class' => 'disabled',
            ]);
    }
}
