<?php

namespace spicyweb\tools\fields;

use spicyweb\tools\Tools as ToolsPlugin;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\PlainText;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;

/**
 * Disabled Plain Text Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledPlainText extends PlainText
{
    // Public Properties
    // =========================================================================
    
    /**
     * @var $size
     */
    public $size = 20;


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Plain Text (Disabled)');
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['size', 'number']
        ]);
        
        return $rules;
    }


    /**
     * Returns the column type that this field should get within the content table.
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * Normalizes the field’s value for use.
     *
     * @param mixed                 $value   The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return mixed The prepared field value
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
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
    public function serializeValue($value, ElementInterface $element = null)
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
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('tools/_components/fields/disabledplaintext/settings',
            [
                'field' => $this
            ]);
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
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('_includes/forms/text',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'maxlength' => $this->size,
                'disabled' => true
            ]);

    }

}
