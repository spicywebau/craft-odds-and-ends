<?php
namespace Craft;

/**
 * Class SuperCoolTools_DisabledCategoriesFieldType
 *
 * @package   SuperCoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

class SuperCoolTools_DisabledCategoriesFieldType extends CategoriesFieldType
{
	// Properties
	// =========================================================================


	/**
	 * Template to use for field rendering
	 *
	 * @var string
	 */
	protected $inputTemplate = 'superCoolTools/fieldtypes/Categories/input';


	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Categories (disabled)');
	}


}
