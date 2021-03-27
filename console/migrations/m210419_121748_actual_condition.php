<?php

use yii\db\Migration;

/**
 * Class m210419_121748_actual_condition
 */
class m210419_121748_actual_condition extends Migration
{
    // Сначала следует:
    // 1. Создать БД выполнив код config/schema.sql из module3-task2
    // 2. Затем выполнить дампы, сгенерированные сценарием сonverter-class-test.php из module3-task2*
    // 3. После действий 1,2 можно выполнять данную миграцию
    //
    // * - прим. после генерации файла cities.sql нужно стереть и заново напечатать в нем эту часть кода: «... cities (﻿name, latitude, ...». Так как почему-то
    // эта часть строки, в том состоянии в котором она генерируется, вызывает ошибку в MySQL.
    public function up()
    {
        $this->alterColumn('users', 'role', $this->string(50)->notNull()->defaultValue('customer'));
        $this->alterColumn('users', 'favorite_count', $this->integer()->unsigned()->notNull()->defaultValue(0));
        $this->alterColumn('users', 'failure_count', $this->integer()->unsigned()->notNull()->defaultValue(0));
        $this->addColumn('users', 'last_activity', $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->addForeignKey('users_ibfk_1', 'users', 'city_id', 'cities', 'id', 'RESTRICT');
        $this->addForeignKey('users_accomplished_tasks_photos_ibfk_1', 'users_accomplished_tasks_photos', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('users_optional_settings_ibfk_1', 'users_optional_settings', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('tasks_ibfk_1', 'tasks', 'customer_id', 'users', 'id', 'RESTRICT');
        $this->addForeignKey('tasks_ibfk_2', 'tasks', 'executant_id', 'users', 'id', 'RESTRICT');
        $this->addForeignKey('tasks_ibfk_3', 'tasks', 'city_id', 'cities', 'id', 'RESTRICT');
        $this->addForeignKey('tasks_ibfk_4', 'tasks', 'specialization_id', 'specializations', 'id', 'RESTRICT');
        $this->addForeignKey('task_helpful_files_ibfk_1', 'task_helpful_files', 'task_id', 'tasks', 'id', 'CASCADE');
        $this->addForeignKey('notifications_history_ibfk_1', 'notifications_history', 'recipient_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('notifications_history_ibfk_2', 'notifications_history', 'task_id', 'tasks', 'id', 'CASCADE');
        $this->addForeignKey('responses_ibfk_1', 'responses', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('responses_ibfk_2', 'responses', 'task_id', 'tasks', 'id', 'CASCADE');
        $this->addForeignKey('chat_messages_ibfk_1', 'chat_messages', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('chat_messages_ibfk_2', 'chat_messages', 'task_id', 'tasks', 'id', 'CASCADE');
        $this->renameColumn('reviews', 'rating', 'rate');
        $this->alterColumn('reviews', 'rate', $this->integer()->unsigned()->notNull());
        $this->addForeignKey('reviews_ibfk_1', 'reviews', 'task_id', 'tasks', 'id', 'CASCADE');
        $this->addForeignKey('reviews_ibfk_2', 'reviews', 'customer_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('reviews_ibfk_3', 'reviews', 'executant_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('user_specialization_ibfk_1', 'user_specialization', 'user_id', 'users', 'id', 'CASCADE');
        $this->addForeignKey('user_specialization_ibfk_2', 'user_specialization', 'specialization_id', 'specializations', 'id', 'CASCADE');

        $newValues = ['2021-04-20 00:56:00', '2021-04-20 00:50:00', '2021-04-20 00:50:00', '2021-04-20 00:32:00', '2021-04-20 00:11:00', '2021-04-20 00:33:00', '2021-04-20 00:31:00', '2021-04-20 00:12:00', '2021-04-20 00:22:00', '2021-04-20 00:33:00', '2021-04-20 00:14:00', '2021-04-20 00:31:00', '2021-04-20 00:21:00', '2021-04-20 00:43:00', '2021-04-20 00:09:00', '2021-04-20 00:01:00', '2021-04-20 00:05:00', '2021-04-20 00:02:00', '2021-04-20 00:42:00', '2021-04-20 00:01:00'];

        for ($id = 1; $id <= 20; $id++) {
            $this->update('users', ['last_activity' => $newValues[$id - 1]], ['id' => $id]);
        }
    }

    public function down()
    {
        echo "m210419_121748_actual_condition cannot be reverted.\n";

        return false;
    }
}
