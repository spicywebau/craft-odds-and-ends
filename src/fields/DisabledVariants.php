<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\commerce\fields\Variants;
use craft\helpers\Template;

/**
 * Disabled Variants Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @since 4.1.0
 */
class DisabledVariants extends Variants
{
    /**
     * @inheritdoc
     */
    protected string $inputTemplate = 'tools/_components/fields/elements/element-select';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Commerce Variants (Disabled)');
    }
}
