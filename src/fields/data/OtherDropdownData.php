<?php

/**
 * Class OtherDropdownData
 *
 * @author    Supercool Ltd <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2017, Supercool Ltd.
 * @see       http://supercooldesign.co.uk
 */

namespace supercool\tools\fields\data;


class OtherDropdownData
{
	// Properties
	// =========================================================================

	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var string
	 */
	public $value;

	/**
	 * @var
	 */
	public $otherValue;

	/**
	 * @var
	 */
	public $selected;

	// Public Methods
	// =========================================================================

	/**
	 * Constructor
	 *
	 * @param string $label
	 * @param string $value
	 * @param        $selected
	 *
	 * @return OptionData
	 */
	public function __construct($label, $value, $otherValue, $selected)
	{
		$this->label      = $label;
		$this->value      = $value;
		$this->otherValue = $otherValue;
		$this->selected   = $selected;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->value;
	}


	/**
	 * @return array|null
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * Sets the options.
	 *
	 * @param array $options
	 *
	 * @return null
	 */
	public function setOptions($options)
	{
		$this->_options = $options;
	}
}
