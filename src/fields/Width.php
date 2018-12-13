<?php
/**
 * SupercoolTools plugin for Craft CMS 3.x
 *
 * SupercoolTools
 *
 * @link      http://supercooldesign.co.uk
 * @copyright Copyright (c) 2017 Supercool
 */

namespace supercool\tools\fields;

use supercool\tools\Tools as ToolsPlugin;
use supercool\tools\assetbundles\tools\ToolsAsset;
use supercool\tools\fields\data\WidthData;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Dropdown;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;
use craft\helpers\ArrayHelper;

/**
 * Width Field
 *
 * @author    Supercool
 * @package   SupercoolTools
 * @since     1.0.0
 */
class Width extends Dropdown
{

    // Static Methods
    // =========================================================================
    
    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Width');
    }

    // Public Methods
    // =========================================================================
    
    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {

        $options = $this->translatedOptions();

        if (!$options)
        {
            // Give it a default row
            $options = array(array('label' => '', 'value' => ''));
        }

        return Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'editableTableField', array(
            array(
                'label'        => $this->optionsSettingLabel(),
                'instructions' => Craft::t('tools', 'Define the available options.'),
                'id'           => 'options',
                'name'         => 'options',
                'addRowLabel'  => Craft::t('tools', 'Add an option'),
                'cols'         => array(
                    'widthValue' => array(
                        'heading'      => Craft::t('tools', 'Width Value'),
                        'type'         => 'singleline',
                        'class'        => 'code'
                    ),
                    'widthDefault' => array(
                        'heading'      => Craft::t('tools', 'Width Default?'),
                        'type'         => 'checkbox',
                        'class'        => 'thin'
                    ),

                    'leftValue' => array(
                        'heading'      => Craft::t('tools', 'Left Value'),
                        'type'         => 'singleline',
                        'class'        => 'code'
                    ),

                    'rightValue' => array(
                        'heading'      => Craft::t('tools', 'Right Value'),
                        'type'         => 'singleline',
                        'class'        => 'code'
                    )
                    
                ),
                'rows' => $options
            )
        ));
    }


    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        if( $value == null ) {
            $options = $this->translatedOptions();
            $data = new WidthData();
            $value = $data->setData($options, $value);
        }

        // Come up with an ID value for 'foo'
        $id = Craft::$app->getView()->formatInputId($this->handle);
     
        // Figure out what that ID is going to be namespaced into
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
                

        return Craft::$app->getView()->renderTemplate( 'tools/_components/fields/width/input', array(
            'name' => $this->handle,
            'value' => $value,
            'namespaceId' => $namespacedId
        ));

    }


    public function normalizeValue($value, ElementInterface $element = null)
    {
        $options = $this->translatedOptions();
        $data = new WidthData();
        $value = $data->setData($options, $value);
        return $value;
    }

    /**
     * Value we are going to save into the database
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
    protected function translatedOptions(): array
    {
        $translatedOptions = [];

        foreach ($this->options as $option) {
            $translatedOptions[] = [
                'widthValue' => $option['widthValue'],
                'widthDefault' => $option['widthDefault'],
                'leftValue' => $option['leftValue'],
                'rightValue' => $option['rightValue'],
            ];
        }

        return $translatedOptions;
    }

}
