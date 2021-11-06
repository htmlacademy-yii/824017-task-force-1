<?php

use yii\db\Migration;

/**
 * Class m210713_190358_alter_table_task_helpful_files
 */
class m210713_190358_alter_table_task_helpful_files extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('task_helpful_files', 'helpful_file', 'path');
    }

    public function safeDown()
    {
        $this->renameColumn('task_helpful_files', 'path', 'helpful_file');
    }
}
