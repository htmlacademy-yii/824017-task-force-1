<?php

namespace frontend\models;

use frontend\models\{
    task\Tasks,
    user\Users,
};
use Yii;

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property string $message
 * @property string $date_time
 */
class ChatMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'message'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['date_time', 'task_id', 'message'], 'safe'],
            ['message', 'string', 'max' => 3000],
            [
                'user_id',
                'exist',
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
            [
                'task_id',
                'exist',
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']
            ],
        ];
    }
}
