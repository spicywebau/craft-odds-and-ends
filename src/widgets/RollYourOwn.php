<?php

namespace spicyweb\oddsandends\widgets;

use Craft;
use craft\base\Widget;
use craft\helpers\Html;
use craft\web\twig\TemplateLoaderException;

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
    public static function icon(): ?string
    {
        return '@spicyweb/oddsandends/icon.svg';
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

        try {
            $output = Craft::$app->getView()->renderTemplate($this->template);
        } catch (TemplateLoaderException $e) {
            // Borrowed from `\craft\fieldlayoutelements\Template::_error()`
            // https://github.com/craftcms/cms/blob/4.4.0/src/fieldlayoutelements/Template.php#L107
            $icon = Html::tag('span', '', [
                'data' => [
                    'icon' => 'alert',
                ],
            ]);
            $content = Html::tag('p', $icon . ' ' . Html::encode($e->getMessage()), [
                'class' => 'error',
            ]);
            $output = Html::tag('div', $content, [
                'class' => 'pane',
            ]);
        }

        Craft::$app->getView()->setTemplateMode($oldMode);

        return $output;
    }
}
