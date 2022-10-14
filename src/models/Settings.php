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
    public $leftDefault = 0;

    /**
     * @var int
     */
    public $rightDefault = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['leftDefault', 'rightDefault'], 'required'],
        ];
    }
}
