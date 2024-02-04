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
    protected string $settingsTemplate = 'tools/_components/fields/ancestors/settings';

    /**
     * @var int[]
     */
    private array $_ancestorIds;

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
    protected function inputHtml(mixed $value, ?ElementInterface $element = null, bool $inline): string
    {
        $this->_ancestorIds = $element->getAncestors()->ids();
        return !empty($this->_ancestorIds)
            ? parent::inputHtml($value, $element, $inline)
            : '<span class="error">' . Craft::t('tools', 'No ancestors exist yet.') . '</span>';
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
        if (!empty($this->_ancestorIds)) {
            return [
                'id' => $this->_ancestorIds,
            ];
        }

        return [];
    }
}
