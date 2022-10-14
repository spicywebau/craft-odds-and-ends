<?php

namespace spicyweb\oddsandends\fields\data;

/**
 * Class WidthData
 *
 * @package spicyweb\oddsandends\fields\data
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Supercool Ltd <naveed@supercooldesign.co.uk>
 * @since 2.1.0
 */
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
