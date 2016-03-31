<?php
namespace Craft;

/**
 * Class SupercoolTools_DisabledEntriesFieldType
 *
 * @package   SupercoolTools
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 */

class SupercoolTools_DisabledEntriesFieldType extends EntriesFieldType
{
	// Properties
	// =========================================================================


	/**
	 * Template to use for field rendering
	 *
	 * @var string
	 */
	protected $inputTemplate = 'supercoolTools/fieldtypes/elements/elementSelect';


	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Entries (disabled)');
	}


}
