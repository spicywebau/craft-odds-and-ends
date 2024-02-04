<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Lightswitch;
use yii\db\Schema;

/**
 * Disabled Lightswitch Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledLightswitch extends Lightswitch
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Lightswitch (Disabled)');
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        // If this is a new entry, look for a default option
        if ($value === null) {
            $value = $this->default;
        }
        
        return (bool)$value;
    }

    /**
     * @inheritdoc
     */
    protected function inputHtml(mixed $value, ?ElementInterface $element = null, bool $inline = false): string
    {
        // If this is a new entry, look for a default option
        if ($this->isFresh($element)) {
            $value = $this->default;
        }

        $id = Craft::$app->getView()->formatInputId($this->handle);

        return Craft::$app->getView()->renderTemplate('_includes/forms/lightswitch',
            [
                'id' => $id,
                'labelId' => $id . '-label',
                'name' => $this->handle,
                'on' => (bool)$value,
                'disabled' => true,
            ]);
    }
}
