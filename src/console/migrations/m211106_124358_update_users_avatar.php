<?php

use yii\db\Migration;

/**
 * Class m211106_124358_update_users_avatar
 */
class m211106_124358_update_users_avatar extends Migration
{
    public function safeUp()
    {
        $dirPath = Yii::getAlias('@frontend/web/img/w3_characters');
        $avatarFiles = array_diff(scandir($dirPath), ['.', '..']);

        $id = 1;
        foreach ($avatarFiles as $file) {
            $this->update('users', ['avatar' => '/img/w3_characters/' . $file], ['id' => $id++]);
        }
    }

    public function safeDown()
    {
        for ($id = 1; $id < 20; $id++) {
            $this->update('users', ['avatar' => null], ['id' => $id++]);
        }
    }
}
