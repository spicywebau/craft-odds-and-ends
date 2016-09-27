<?php

namespace Craft;

class SupercoolTools_DefaultNumberFieldTypeSettingsModel extends NumberFieldTypeSettingsModel
{

	public function rules()
	{
		$rules = parent::rules();

		return $rules;
	}

	protected function defineAttributes()
	{
		$attributes = parent::defineAttributes();

		$attributes['defaultNumber'] = array(AttributeType::Number);

		return $attributes;
	}
}