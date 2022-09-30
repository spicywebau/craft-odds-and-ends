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
    // Properties
    // =========================================================================

    public bool $allowMultipleSources = false;

    /**
     * Template to use for field rendering
     *
     * @var string
     */
    protected string $inputTemplate = 'tools/_components/fields/ancestors/input';

    /**
     * Template to use for field settings
     *
     * @var string
     */
    protected string $settingsTemplate = 'tools/_components/fields/ancestors/settings';

    private $ourElement;


    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Ancestors');
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
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        /** @var Element $element */
        // if ($element !== null && $element->hasEagerLoadedElements($this->handle)) {
        //     $value = $element->getEagerLoadedElements($this->handle);
        // }
        
        $this->ourElement = $element;

        /** @var ElementQuery|array $value */
        $variables = $this->inputTemplateVariables($value, $element);

        return Craft::$app->getView()->renderTemplate($this->inputTemplate, $variables);
    }


    /**
     * Returns an array of the source keys the field should be able to select elements from.
     *
     * @param ElementInterface|null $element
     *
     * @return array|string
     */
    protected function inputSources(?ElementInterface $element = null)
    {
        $sources = ['section:' . $element->section->uid];

        return $sources;
    }

    /**
     * Returns any additional criteria parameters limiting which elements the field should be able to select.
     *
     * @return array
     */
    protected function inputSelectionCriteria(): array
    {

        // Return the current elements ancestors, if there are any
        $ids = $this->ourElement->getAncestors()->ids();

        if (count($ids)) {
            return [
                'id' => $ids,
            ];
        }

        // If there is a parent id param then its a new child entry
        // $parentId = Craft::$app->getRequest()->getParam('parentId');
        // $ids = [];
        // if ($parentId)
        // {
        //     $parent = craft()->elements->getElementById($parentId);
        //     $ids[] = $parent->id;

        //     $criteria = craft()->elements->getCriteria($this->elementType);
        //     $criteria->ancestorOf = $parent->id;
        //     $criteria->locale     = $parent->locale;

        //     return [
        //         'id' => array_merge($ids, $criteria->ids())
        //     ];
        // }

        return [];
    }
}
