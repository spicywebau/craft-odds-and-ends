<?php
namespace spicyweb\oddsandends\migrations;

use spicyweb\oddsandends\fields\Ancestors;
use spicyweb\oddsandends\fields\AuthorInstructions;
use spicyweb\oddsandends\fields\CategoriesMultipleGroups;
use spicyweb\oddsandends\fields\CategoriesSearch;
use spicyweb\oddsandends\fields\DisabledCategories;
use spicyweb\oddsandends\fields\DisabledDropdown;
use spicyweb\oddsandends\fields\DisabledEntries;
use spicyweb\oddsandends\fields\DisabledLightswitch;
use spicyweb\oddsandends\fields\DisabledNumber;
use spicyweb\oddsandends\fields\DisabledPlainText;
use spicyweb\oddsandends\fields\EntriesSearch;
use spicyweb\oddsandends\fields\Grid;
use spicyweb\oddsandends\fields\Width;

use Craft;
use craft\db\Migration;

class m230911_000000_supercool_fields_migration extends Migration
{
    // Public Methods
    // =========================================================================

    public function safeUp(): bool
    {
        $this->update('{{%fields}}', ['type' => Ancestors::class], ['type' => 'supercool\tools\fields\Ancestors']);
        $this->update('{{%fields}}', ['type' => AuthorInstructions::class], ['type' => 'supercool\tools\fields\AuthorInstructions']);
        $this->update('{{%fields}}', ['type' => CategoriesMultipleGroups::class], ['type' => 'supercool\tools\fields\CategoriesMultipleGroups']);
        $this->update('{{%fields}}', ['type' => CategoriesSearch::class], ['type' => 'supercool\tools\fields\CategoriesSearch']);
        $this->update('{{%fields}}', ['type' => DisabledCategories::class], ['type' => 'supercool\tools\fields\DisabledCategories']);
        $this->update('{{%fields}}', ['type' => DisabledDropdown::class], ['type' => 'supercool\tools\fields\DisabledDropdown']);
        $this->update('{{%fields}}', ['type' => DisabledEntries::class], ['type' => 'supercool\tools\fields\DisabledEntries']);
        $this->update('{{%fields}}', ['type' => DisabledLightswitch::class], ['type' => 'supercool\tools\fields\DisabledLightswitch']);
        $this->update('{{%fields}}', ['type' => DisabledNumber::class], ['type' => 'supercool\tools\fields\DisabledNumber']);
        $this->update('{{%fields}}', ['type' => DisabledPlainText::class], ['type' => 'supercool\tools\fields\DisabledPlainText']);
        $this->update('{{%fields}}', ['type' => EntriesSearch::class], ['type' => 'supercool\tools\fields\EntriesSearch']);
        $this->update('{{%fields}}', ['type' => Grid::class], ['type' => 'supercool\tools\fields\Grid']);
        $this->update('{{%fields}}', ['type' => Width::class], ['type' => 'supercool\tools\fields\Width']);

        return true;
    }

    public function safeDown(): bool
    {
        echo "m230911_000000_supercool_fields_migration cannot be reverted.\n";
        return false;
    }
}
