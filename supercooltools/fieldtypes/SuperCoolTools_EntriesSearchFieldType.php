<?php
namespace Craft;

/**
 * Class SuperCoolTools_EntriesSearchFieldType
 *
 * @package   SuperCoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

class SuperCoolTools_EntriesSearchFieldType extends BaseElementFieldType
{

	// Properties
	// =========================================================================

	/**
	 * The element type this field deals with.
	 *
	 * @var string $elementType
	 */
	protected $elementType = 'Entry';

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Entries (search)');
	}

	/**
	 * @inheritDoc IFieldType::getInputHtml()
	 *
	 * @param string $name
	 * @param mixed  $criteria
	 *
	 * @return string
	 */
	public function getInputHtml($name, $criteria)
	{
		$variables = $this->getInputTemplateVariables($name, $criteria);
		return craft()->templates->render('superCoolTools/fieldtypes/EntriesSearch/input', $variables);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseElementFieldType::getAddButtonLabel()
	 *
	 * @return string
	 */
	protected function getAddButtonLabel()
	{
		return Craft::t('Add an entry');
	}

}
