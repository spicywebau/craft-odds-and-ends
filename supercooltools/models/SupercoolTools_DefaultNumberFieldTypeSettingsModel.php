<?php

namespace Craft;

/**
 * Class SupercoolTools_DefaultNumberFieldTypeSettingsModel
 *
 * @package   SupercoolTools
 * @author    Naveed Ziarab <naveed@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DefaultNumberFieldTypeSettingsModel extends NumberFieldTypeSettingsModel
{

	/**
	 * @inheritDoc BaseModel::defineAttributes()
	 * 
	 * @return array
	 */
	protected function defineAttributes()
	{
		$attributes = parent::defineAttributes();

		$attributes['defaultNumber'] = array(AttributeType::Number);

		return $attributes;
	}


	/**
	 * @inheritDoc BaseModel::rules()
	 * 
	 * @return array
	 */
	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('defaultNumber', 'required');
		$rules[] = array('defaultNumber', 'validateDefaultNumber');

		if( $this->decimals && intval($this->decimals) && intval($this->decimals) > 0 ) 
		{
			foreach( $rules as $key => &$rule ) 
			{
				if( $rule[0] == 'defaultNumber' && $rule[1] == 'numerical' ) 
				{
					$rule['integerOnly'] = false;
				}
			}
		}


		return $rules;
	}


	/**
	 * 
	 */
	public function validateDefaultNumber( $attribute )
	{
		$value = $this->defaultNumber;
		$min = $this->min;
		$max = $this->max;

		if( $value < $min ) {
			$message = Craft::t("Number must be equal or greater than ".$min);
			$this->addError($attribute, $message);
		} elseif( $max != "" && $value > $max ) {
			$message = Craft::t("Number must be equal or less than ".$max);
			$this->addError($attribute, $message);
		}

	}

}