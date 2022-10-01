<?php

namespace spicyweb\tools\fields;

use Craft;

use craft\base\ElementInterface;
use craft\fields\Dropdown;
use craft\helpers\Json;
use spicyweb\tools\fields\data\WidthData;
use yii\db\Schema;

/**
 * Width Field
 *
 * @package spicyweb\tools\fields
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
    public function getSettingsHtml()
    {
        $options = $this->translatedOptions();

        if (!$options) {
            // Give it a default row
            $options = [['label' => '', 'value' => '']];
        }

        return Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'editableTableField', [
            [
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
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
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
    public function normalizeValue($value, ElementInterface $element = null)
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
    public function serializeValue($value, ElementInterface $element = null)
    {
        $value = Json::encode($value);
        return $value;
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
    public function getElementValidationRules(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function validateOptions()
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
    protected function translatedOptions(bool $encode = false): array
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
