<?php

namespace spicyweb\oddsandends\models;

use craft\base\Model;

/**
 * Class Settings
 *
 * @package spicyweb\oddsandends\models
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.1.4
 */
class Settings extends Model
{
    /**
     * @var int
     */
    public int $leftDefault = 0;

    /**
     * @var int
     */
    public int $rightDefault = 0;

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return [
            [['leftDefault', 'rightDefault'], 'required'],
        ];
    }
}
