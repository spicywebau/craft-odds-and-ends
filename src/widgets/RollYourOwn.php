<?php

namespace spicyweb\oddsandends\widgets;

use Craft;
use craft\base\Widget;

/**
 * Roll Your Own Widget
 *
 * @package spicyweb\oddsandends\widgets
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class RollYourOwn extends Widget
{
    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string
     */
    public string $template = "_dashboard";

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Roll Your Own');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'tools/_components/widgets/rollyourown/settings',
            [
                'widget' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): ?string
    {
        return $this->title ? Craft::t('site', $this->title) : static::displayName();
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml(): ?string
    {
        $oldMode = Craft::$app->getView()->getTemplateMode();
        Craft::$app->getView()->setTemplateMode('site');

        $output = Craft::$app->getView()->renderTemplate($this->template);

        Craft::$app->getView()->setTemplateMode($oldMode);

        return $output;
    }
}
