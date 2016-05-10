<?php
namespace Craft;

/**
 * Class SupercoolTools_DisabledCategoriesFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DisabledCategoriesFieldType extends CategoriesFieldType
{
	// Properties
	// =========================================================================


	/**
	 * Template to use for field rendering
	 *
	 * @var string
	 */
	protected $inputTemplate = 'supercoolTools/fieldtypes/Categories/input';


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
