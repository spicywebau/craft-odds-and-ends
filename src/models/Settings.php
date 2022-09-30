<?php

namespace spicyweb\tools\models;

use craft\base\Model;

/**
 * Class Settings
 *
 * @package spicyweb\tools\models
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool
 * @since 2.1.4
 */
class Settings extends Model
{
    public int $leftDefault = 0;
    public int $rightDefault = 0;

    public function rules(): array
    {
        return [
            [['leftDefault', 'rightDefault'], 'required'],
            // ...
        ];
    }
}
