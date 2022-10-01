<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\fields\Entries;
use craft\helpers\Template;

/**
 * Ancestors Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class Ancestors extends Entries
{
    /**
     * @inheritdoc
     */
    public $allowMultipleSources = false;

    /**
     * @inheritdoc
     */
    protected $inputTemplate = 'tools/_components/fields/ancestors/input';

    /**
     * @inheritdoc
     */
    protected $settingsTemplate = 'tools/_components/fields/ancestors/settings';

    /**
     * @var ElementInterface|null
     */
    private $ourElement;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Ancestors');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate($this->settingsTemplate, [
            'targetLocaleField' => $this->getTargetSiteFieldHtml(),
            'field' => $this,
        ]);
    }

    /**
    * @inheritdoc
    */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $this->ourElement = $element;
        $variables = $this->inputTemplateVariables($value, $element);

        return Craft::$app->getView()->renderTemplate($this->inputTemplate, $variables);
    }

    /**
     * @inheritdoc
     */
    protected function inputSources(ElementInterface $element = null)
    {
        $sources = ['section:' . $element->section->uid];

        return $sources;
    }

    /**
     * @inheritdoc
     */
    protected function inputSelectionCriteria(): array
    {
        // Return the current element's ancestors, if there are any
        $ids = $this->ourElement->getAncestors()->ids();

        if (count($ids)) {
            return [
                'id' => $ids,
            ];
        }

        return [];
    }
}
