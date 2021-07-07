<?php

use yii\db\Migration;

/**
 * Class m210713_190358_alter_table_task_helpful_files
 */
class m210713_190358_alter_table_task_helpful_files extends Migration
{
    public function up()
    {
        $this->renameColumn('task_helpful_files', 'helpful_file', 'path');
    }

    public function down()
    {
        $this->renameColumn('task_helpful_files', 'path', 'helpful_file');
    }
}
