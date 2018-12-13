<?php

namespace supercool\tools\models;

use craft\base\Model;

class Settings extends Model
{
    public $leftDefault = 0;
    public $rightDefault = 0;

    public function rules()
    {
        return [
            [['leftDefault', 'rightDefault'], 'required'],
            // ...
        ];
    }
}