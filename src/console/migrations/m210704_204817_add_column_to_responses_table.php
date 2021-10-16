<?php

use yii\db\Migration;

/**
 * Class m210704_204817_add_column_to_responses_table
 */
class m210704_204817_add_column_to_responses_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('responses', 'is_refused', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('responses', 'is_refused');
    }
}
