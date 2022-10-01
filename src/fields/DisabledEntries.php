<?php

namespace spicyweb\tools\fields;

use Craft;
use craft\fields\Entries;
use craft\helpers\Template;

/**
 * Disabled Entries Field
 *
 * @package spicyweb\tools\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.0.0
 */
class DisabledEntries extends Entries
{
    /**
     * @inheritdoc
     */
    protected $inputTemplate = 'tools/_components/fields/elements/element-select';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('tools', 'Entries (Disabled)');
    }
}
