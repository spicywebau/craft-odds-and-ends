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
	 * @inheritDoc BaseModel::rules()
	 * 
	 * @return array
	 */
	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('defaultNumber', 'required');
		return $rules;
	}

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
}