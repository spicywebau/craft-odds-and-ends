<?php

namespace spicyweb\tools\migrations;

use Craft;
use craft\db\Migration;
use craft\db\Table;
use spicyweb\tools\Tools;
use spicyweb\tools\widgets\RollYourOwn;

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
        $newClassPrefix = preg_replace('/Tools$/', '', Tools::class);
        $oldClassPrefix = preg_replace('/^spicyweb/', 'supercool', $newClassPrefix);

        foreach ($projectConfig->get('fields') ?? [] as $uid => $field) {
            if (strpos($field['type'], $oldClassPrefix) === 0) {
                $projectConfig->set("fields.$uid.type", preg_replace('/^supercool/', 'spicyweb', $field['type']));
            }
        }

        // Update widget types
        $this->update(
            Table::WIDGETS,
            ['type' => RollYourOwn::class],
            ['type' => preg_replace('/^spicyweb/', 'supercool', RollYourOwn::class)]
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
