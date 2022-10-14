<?php

namespace spicyweb\oddsandends\migrations;

use Craft;
use craft\db\Migration;
use craft\db\Table;
use spicyweb\oddsandends\Tools;
use spicyweb\oddsandends\widgets\RollYourOwn;

/**
 * m220921_060212_update_developer_in_db migration.
 */
class m220921_060212_update_developer_in_db extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Update field types
        $projectConfig = Craft::$app->getProjectConfig();
        $newClassPrefix = preg_replace('/Plugin$/', '', Tools::class);
        $oldClassPrefix = preg_replace('/^spicyweb\\\\oddsandends/', 'supercool\\tools', $newClassPrefix);

        foreach ($projectConfig->get('fields') ?? [] as $uid => $field) {
            if (strpos($field['type'], $oldClassPrefix) === 0) {
                $projectConfig->set(
                    "fields.$uid.type",
                    preg_replace('/^supercool\\\\tools/', 'spicyweb\\oddsandends', $field['type'])
                );
            }
        }

        // Update widget types
        $this->update(
            Table::WIDGETS,
            ['type' => RollYourOwn::class],
            ['type' => preg_replace('/^spicyweb\\\\oddsandends/', 'supercool\\tools', RollYourOwn::class)]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m220921_060212_update_developer_in_db cannot be reverted.\n";
        return false;
    }
}
