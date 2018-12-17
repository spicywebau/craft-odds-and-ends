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
use supercool\tools\fields\data\GridData;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;
use craft\helpers\ArrayHelper;

/**
 * Grid Field
 *
 * @author    Supercool
 * @package   SupercoolTools
 * @since     1.0.0
 */

class Grid extends Field implements PreviewableFieldInterface
{

    // Properties
    // =========================================================================

    /**
     * @var int The default value for total columns
     */
    public $totalColumns = 12;

    /**
     * @var int The default value for left pointer
     */
    public $leftDefault;

    /**
     * @var int The default value for right pointer
     */
    public $rightDefault;


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Grid');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('tools/_components/fields/grid/settings',
        [
            'field' => $this
        ]);
    }


    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Come up with an ID value for 'foo'
        $id = Craft::$app->getView()->formatInputId($this->handle);

        // Figure out what that ID is going to be namespaced into
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);


        return Craft::$app->getView()->renderTemplate( 'tools/_components/fields/grid/input', array(
            'name' => $this->handle,
            'value' => $value,
            'namespaceId' => $namespacedId
        ));

    }


    public function normalizeValue($value, ElementInterface $element = null)
    {
        $this->leftDefault = ToolsPlugin::getInstance()->getSettings()->leftDefault;
        $this->rightDefault = ToolsPlugin::getInstance()->getSettings()->rightDefault;
        if ( !$value )
        {
            $value = new GridData($this->totalColumns, 0, 0, $this->leftDefault, $this->rightDefault);
        }

        if (is_string($value))
        {
            $value = json_decode($value);
            $value = new GridData($this->totalColumns, $value->left, $value->right, $this->leftDefault, $this->rightDefault);
        }

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

}
