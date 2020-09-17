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
    public $minColumnSpan;
    public $maxColumnSpan;

    public function __construct($totalColumns = null,
                                $left = null,
                                $right = null,
                                $leftDefault = null,
                                $rightDefault = null,
                                $minColumnSpan = null,
                                $maxColumnSpan = null)
    {
        $this->totalColumns = (int) $totalColumns;
        $this->left = (int) $left;
        $this->right = (int) $right;
        $this->leftDefault = (int) $leftDefault;
        $this->rightDefault = (int) $rightDefault;
        $this->minColumnSpan = (int) $minColumnSpan;
        $this->maxColumnSpan = $maxColumnSpan ? (int) $maxColumnSpan : null;
    }

    public function __toString()
    {
        return $this->left . ',' . $this->right;
    }

    public function leftRight()
    {
        return $this->left . ',' . $this->right;
    }

}
