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
use supercool\tools\fields\data\OtherDropdownData;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Dropdown;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;
use craft\helpers\ArrayHelper;

/**
 * Other Dropdown Field
 *
 * @author    Supercool
 * @package   SupercoolTools
 * @since     1.0.0
 */
class OtherDropdown extends Dropdown
{

    public $otherLabel;
    public $otherPlaceholder;

    // Static Methods
    // =========================================================================
    
    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Dropdown (Other)');
    }

    // Public Methods
    // =========================================================================
    
    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $parentSettingsTemplate = parent::getSettingsHtml();

        $settingsTemplate = Craft::$app->getView()->renderTemplate('tools/_components/fields/otherdropdown/settings', [
            'field' => $this
        ]);

        return $parentSettingsTemplate . $settingsTemplate;
    }


    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        $options = $this->translatedOptions();

        // Setting the Other label
        $otherLabel = $this->otherLabel;

        if( $otherLabel == "" )
        {
            $otherLabel = "Other";
        }

        // Add the other option
        $options[] = ['label' => $otherLabel, 'value' => 'other', 'default' => ''];

        // If this is a new entry, look for a default option
        if ($this->isFresh($element) || $value == null)
        {
            $value = $this->defaultValue();
        }

        return Craft::$app->getView()->renderTemplate('tools/_components/fields/Otherdropdown/input', [
            'name'    => $this->handle,
            'value'   => $value,
            'options' => $options,
            'field' => $this
        ]);

    }


    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value)
        {
            if ( is_string($value) )
            {
                $value = Json::decode($value);    
            }
            
            $selectedValues = ArrayHelper::toArray($value);

            // Setting the label for selected value
            $label = $this->optionLabel($value['dropdown']);

            if($label == "other" )
            {
                $label = $this->otherLabel;
            }

            $value = new OtherDropdownData($label, $value['dropdown'], $value['otherValue'], true);

            $options = array();

            foreach ($this->options as $option)
            {
                $selected = in_array($option['value'], $selectedValues);
                $options[] = new OtherDropdownData($option['label'], $option['value'], null, $selected);
            }

            // Add other in the options
            $selected = in_array('other', $selectedValues);
            $options[] = new OtherDropdownData($this->otherLabel, 'other', $value->otherValue, $selected);

            // Set all the options
            $value->setOptions($options);
        }

        return $value;
    }

    /**
     * Value we are going to save into the database
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if ( $value )
        {
            $dbValue['dropdown'] = $value->value;
            $dbValue['otherValue'] = $value->otherValue;

            if ( $value->value != 'other' )
            {
                $dbValue['otherValue'] = "";
            }

            $value = Json::encode($dbValue);
        }

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
        return ['otherValueValidation'];
    }


    public function otherValueValidation(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        if ( $value->value == "other" && $value->otherValue == "" )
        {
            $element->addError($this->handle, Craft::t('tools', 'You have selected "{otherLabel}" but not entered a value in this field.', ['otherLabel' => $value->label]));
        }
    }

}
