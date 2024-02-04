<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\fields\Dropdown;
use craft\helpers\Cp;
use craft\helpers\Json;
use GraphQL\Type\Definition\Type;
use spicyweb\oddsandends\fields\data\WidthData;
use yii\db\Schema;

/**
 * Width Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class Width extends Dropdown
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Width');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        $options = $this->translatedOptions();

        if (!$options) {
            // Give it a default row
            $options = [['label' => '', 'value' => '']];
        }

        return Cp::editableTableFieldHtml([
            'label' => $this->optionsSettingLabel(),
            'instructions' => Craft::t('tools', 'Define the available options.'),
            'id' => 'options',
            'name' => 'options',
            'addRowLabel' => Craft::t('tools', 'Add an option'),
            'cols' => [
                'widthValue' => [
                    'heading' => Craft::t('tools', 'Width Value'),
                    'type' => 'singleline',
                    'class' => 'code',
                ],
                'widthDefault' => [
                    'heading' => Craft::t('tools', 'Width Default?'),
                    'type' => 'checkbox',
                    'class' => 'thin',
                ],

                'leftValue' => [
                    'heading' => Craft::t('tools', 'Left Value'),
                    'type' => 'singleline',
                    'class' => 'code',
                ],

                'rightValue' => [
                    'heading' => Craft::t('tools', 'Right Value'),
                    'type' => 'singleline',
                    'class' => 'code',
                ],

            ],
            'rows' => $options,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null, bool $inline = false): string
    {
        if ($value == null) {
            $options = $this->translatedOptions();
            $data = new WidthData();
            $value = $data->setData($options, $value);
        }

        // Come up with an ID value for 'foo'
        $id = Craft::$app->getView()->formatInputId($this->handle);

        // Figure out what that ID is going to be namespaced into
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);


        return Craft::$app->getView()->renderTemplate('tools/_components/fields/width/input', [
            'name' => $this->handle,
            'value' => $value,
            'namespaceId' => $namespacedId,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        if ($value instanceof WidthData) {
            return $value;
        }

        $options = $this->translatedOptions();
        $data = new WidthData();
        $value = $data->setData($options, $value);
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        $value = Json::encode($value);
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function validateOptions(): void
    {
        $widthValues = [];
        $leftValues = [];
        $rightValues = [];
        $hasDuplicateWidthValues = false;
        $hasDuplicateLeftValues = false;
        $hasDuplicateRightValues = false;

        foreach ($this->options as &$option) {
            $widthValue = (string)$option['widthValue'];
            if (isset($widthValues[$widthValue])) {
                $hasDuplicateWidthValues = true;
            }

            $leftValue = (string)$option['leftValue'];
            if (isset($leftValues[$leftValue])) {
                $hasDuplicateLeftValues = true;
            }

            $rightValue = (string)$option['rightValue'];
            if (isset($rightValues[$rightValue])) {
                $hasDuplicateRightValues = true;
            }
        }

        if ($hasDuplicateWidthValues) {
            $this->addError('options', Craft::t('app', 'All width values must be unique.'));
        }

        if ($hasDuplicateLeftValues) {
            $this->addError('options', Craft::t('app', 'All left values must be unique.'));
        }

        if ($hasDuplicateRightValues) {
            $this->addError('options', Craft::t('app', 'All right values must be unique.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function getStatus(ElementInterface $element): ?array
    {
        try {
            return parent::getStatus($element);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function getContentGqlMutationArgumentType(): Type|array
    {
        // Using the code from \craft\base\Field::getContentGqlMutationArgumentType() due to an error that was occurring
        // with GraphQL queries.
        // TODO: either extend something other than Dropdown, or figure out another way to avoid the error and let this
        // field type support GraphQL mutations.
        return [
            'name' => $this->handle,
            'type' => Type::string(),
            'description' => $this->instructions,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function translatedOptions(bool $encode = false, mixed $value = null, ?ElementInterface $element = null): array
    {
        $translatedOptions = [];

        foreach ($this->options as $option) {
            if ($encode) {
                $translatedOptions[] = [
                    'widthValue' => $this->encodeValue($option['widthValue']),
                    'widthDefault' => $this->encodeValue($option['widthDefault']),
                    'leftValue' => $this->encodeValue($option['leftValue']),
                    'rightValue' => $this->encodeValue($option['rightValue']),
                ];
            } else {
                $translatedOptions[] = [
                    'widthValue' => $option['widthValue'],
                    'widthDefault' => $option['widthDefault'],
                    'leftValue' => $option['leftValue'],
                    'rightValue' => $option['rightValue'],
                ];
            }
        }

        return $translatedOptions;
    }
}
