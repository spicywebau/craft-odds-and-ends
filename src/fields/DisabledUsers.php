<?php

namespace spicyweb\oddsandends\fields;

use Craft;
use craft\fields\Users;
use craft\helpers\Template;

/**
 * Disabled Users Field
 *
 * @package spicyweb\oddsandends\fields
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @since 4.3.0
 */
class DisabledUsers extends Users
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
        return Craft::t('tools', 'Users (Disabled)');
    }
}
