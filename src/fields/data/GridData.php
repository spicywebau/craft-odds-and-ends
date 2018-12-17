<?php

/**
 * Class GridData
 *
 * @author    Supercool Ltd <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2018, Supercool Ltd.
 * @see       http://supercooldesign.co.uk
 */

namespace supercool\tools\fields\data;

use craft\helpers\Json;


class GridData
{

    public $totalColumns;
    public $left;
    public $right;
    public $leftDefault;
    public $rightDefault;

    public function __construct($totalColumns = null,
                                $left = null,
                                $right = null,
                                $leftDefault = null,
                                $rightDefault = null)
    {
        $this->totalColumns = $totalColumns;
        $this->left = $left;
        $this->right = $right;
        $this->leftDefault = $leftDefault;
        $this->rightDefault = $rightDefault;


    }

    public function __toString()
    {
        return $this->left . ',' . $this->right;
    }

}
