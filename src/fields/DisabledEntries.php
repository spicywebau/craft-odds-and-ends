<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\fields\Entries;
use craft\helpers\Template;

/**
 * Disabled Entries Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledEntries extends Entries
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
        return Craft::t('tools', 'Entries (Disabled)');
    }
}
