<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\fields\Entries;
use craft\helpers\Template;

/**
 * Ancestors Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class Ancestors extends Entries
{
    /**
     * @inheritdoc
     */
    public bool $allowMultipleSources = false;

    /**
     * @inheritdoc
     */
    protected string $inputTemplate = 'tools/_components/fields/ancestors/input';

    /**
     * @inheritdoc
     */
    protected string $settingsTemplate = 'tools/_components/fields/ancestors/settings';

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
    public static function defaultSelectionLabel(): string
    {
        return Craft::t('tools', 'Add an ancestor');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate($this->settingsTemplate, [
            'targetLocaleField' => $this->getTargetSiteFieldHtml(),
            'field' => $this,
        ]);
    }

    /**
    * @inheritdoc
    */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        $this->ourElement = $element;
        $variables = $this->inputTemplateVariables($value, $element);

        return Craft::$app->getView()->renderTemplate($this->inputTemplate, $variables);
    }

    /**
     * @inheritdoc
     */
    public function getInputSources(?ElementInterface $element = null): array|string|null
    {
        $sources = ['section:' . $element->section->uid];

        return $sources;
    }

    /**
     * @inheritdoc
     */
    public function getInputSelectionCriteria(): array
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
