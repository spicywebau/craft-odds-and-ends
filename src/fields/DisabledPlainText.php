<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\PlainText;
use yii\db\Schema;

/**
 * Disabled Plain Text Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledPlainText extends PlainText
{
    /**
     * @var int
     */
    public int $size = 20;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Plain Text (Disabled)');
    }

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules = array_merge($rules, [
            ['size', 'number'],
        ]);
        
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('tools/_components/fields/disabledplaintext/settings',
            [
                'field' => $this,
            ]);
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('_includes/forms/text',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'maxlength' => $this->size,
                'disabled' => true,
            ]);
    }
}
