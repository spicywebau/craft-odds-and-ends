<?php
namespace Craft;

/**
 * Class WidthData
 *
 * @author    Supercool Ltd <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd.
 * @see       http://supercooldesign.co.uk
 */

class WidthData
{

	public $width;
	public $left;
	public $right;

	public $widthOptions;
	public $leftOptions;
	public $rightOptions;

	public function __construct($widthOptions = null,
								$leftOptions = null,
								$rightOptions = null,
								$width = null,
								$left = null,
								$right = null)
	{
		$this->widthOptions = $widthOptions;
		$this->leftOptions = $leftOptions;
		$this->rightOptions = $rightOptions;

		$this->width = $width;
		$this->left = $left;
		$this->right = $right;
	}

	public function __toString()
	{
		return $this->width;
	}


	public function setData($options, $value)
	{
		$widthOptions = array();
		$leftOptions  = array();
		$rightOptions = array();

		$width = "";
		$left  = "";
		$right = "";

		foreach ($options as $option) 
		{
			$widthOptions[] = $option['widthValue'];
			$leftOptions[]  = $option['leftValue'];
			$rightOptions[] = $option['rightValue'];

			if ( $option['widthDefault'] == 1 ) 
			{
				$width = $option['widthValue'];
			}

			if ( $option['leftDefault'] == 1 ) 
			{
				$left = $option['leftValue'];
			}

			if ( $option['rightDefault'] == 1 ) 
			{
				$right = $option['rightValue'];
			}
		}

		if ( $value )
		{
			$width = $value['width'];
			$left  = $value['left'];
			$right = $value['right'];
		}

		return new self( $widthOptions, $leftOptions, $rightOptions, $width, $left, $right );
	}

}