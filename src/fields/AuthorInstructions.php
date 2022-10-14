<?php

namespace spicyweb\oddsandends\fields;

use Craft;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Template;
use spicyweb\oddsandends\assetbundles\tools\ToolsAsset;
use yii\db\Schema;

/**
 * AuthorInstructions Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class AuthorInstructions extends Field
{
    /**
     * @var string
     */
    public $authorInstructions;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Author Instructions');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['authorInstructions', 'required'],
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
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'tools/_components/fields/authorinstructions/settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        Craft::$app->getView()->registerAssetBundle(ToolsAsset::class);

        return Craft::$app->getView()->renderTemplate(
            'tools/_components/fields/authorinstructions/input',
            [
                'name' => $name,
                'value' => $value,
                'authorInstructions' => $this->authorInstructions,
            ]
        );
    }
}
