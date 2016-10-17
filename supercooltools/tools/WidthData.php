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

	public $firstPointer;
	public $secondPointer;
	public $thirdPointer;
	public $fourthPointer;

	public $widthOptions;
	public $leftOptions;
	public $rightOptions;

	public function __construct($widthOptions = null,
								$leftOptions = null,
								$rightOptions = null,
								$width = null,
								$left = null,
								$right = null,
								$firstPointer = null,
								$secondPointer = null,
								$thirdPointer = null,
								$fourthPointer = null)
	{
		$this->widthOptions = $widthOptions;
		$this->leftOptions = $leftOptions;
		$this->rightOptions = $rightOptions;

		$this->width = $width;
		$this->left = $left;
		$this->right = $right;

		$this->firstPointer = $firstPointer;
		$this->secondPointer = $secondPointer;
		$this->thirdPointer = $thirdPointer;
		$this->fourthPointer = $fourthPointer;
	}

	public function __toString()
	{
		return $this->left . " " . $this->width . " " . $this->right;
	}


	public function setData($options, $value)
	{
		$widthOptions = array();
		$leftOptions  = array();
		$rightOptions = array();

		$width = "";
		$left  = "";
		$right = "";

		$firstPointer = 0;
		$secondPointer = 0;
		$thirdPointer = 0;
		$fourthPointer = 0;

		$total = count($options);

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
		// Set Keys and pointers
		$widthKey = array_search($width, $widthOptions);
		$leftKey = array_search($left, $leftOptions);
		$rightKey = array_search($right, $rightOptions);

		if ( $leftKey !== false ) {
			$leftKey = $leftKey + 1;

			$firstPointer = $leftKey - $total;
			$secondPointer = $leftKey;
		}

		if ( $widthKey !== false ) {
			$widthKey = $widthKey + 1;

			$thirdPointer = $leftKey + $widthKey;
		}

		if ( $rightKey !== false ) {
			$rightKey = $rightKey + 1;

			$fourthPointer = ($leftKey + $widthKey) + $rightKey;
		}

		

		if ( $value )
		{
			$width = $value['width'];
			$left  = $value['left'];
			$right = $value['right'];

			$firstPointer = $value['firstPointer'] ?? 0;
			$secondPointer = $value['secondPointer'] ?? 0;
			$thirdPointer = $value['thirdPointer'] ?? 0;
			$fourthPointer = $value['fourthPointer'] ?? 0;
		}

		return new self( $widthOptions, $leftOptions, $rightOptions, $width, $left, $right,
						$firstPointer, $secondPointer, $thirdPointer, $fourthPointer );
	}

}