<?php

namespace spicyweb\tools\fields;

use spicyweb\tools\Tools as ToolsPlugin;
use spicyweb\tools\assetbundles\tools\ToolsAsset;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Entries;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\helpers\Template;
use craft\elements\Entry;

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

    public $allowMultipleSources = false;

    /**
     * Template to use for field rendering
     *
     * @var string
     */
    protected $inputTemplate = 'tools/_components/fields/ancestors/input';

    /**
     * Template to use for field settings
     *
     * @var string
     */
    protected $settingsTemplate = 'tools/_components/fields/ancestors/settings';

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
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate($this->settingsTemplate, [
            'targetLocaleField'    => $this->getTargetSiteFieldHtml(),
            'field' => $this,
        ]);
    }


     /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
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
    protected function inputSources(ElementInterface $element = null)
    {
        $sources = array('section:'.$element->section->uid);

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

        if (count($ids))
        {
            return array(
                'id' => $ids
            );
        }

        // If there is a parent id param then its a new child entry
        // $parentId = Craft::$app->getRequest()->getParam('parentId');
        // $ids = array();
        // if ($parentId)
        // {
        //     $parent = craft()->elements->getElementById($parentId);
        //     $ids[] = $parent->id;

        //     $criteria = craft()->elements->getCriteria($this->elementType);
        //     $criteria->ancestorOf = $parent->id;
        //     $criteria->locale     = $parent->locale;

        //     return array(
        //         'id' => array_merge($ids, $criteria->ids())
        //     );
        // }

        return [];
    }

}
