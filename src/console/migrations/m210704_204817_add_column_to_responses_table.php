<?php

use yii\db\Migration;

/**
 * Class m210704_204817_add_column_to_responses_table
 */
class m210704_204817_add_column_to_responses_table extends Migration
{
    public function up()
    {
        $this->addColumn('responses', 'is_refused', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('responses', 'is_refused');
    }
}
