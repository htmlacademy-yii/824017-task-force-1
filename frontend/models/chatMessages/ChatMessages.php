<?php

namespace frontend\models\chatMessages;

use Yii;
use frontend\models\{
    task\Tasks,
    user\Users,
};

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property string $message
 * @property string $date_time
 *
 * @property User $user
 * @property Task $task
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
            ['date_time', 'safe'],
            ['message', 'string', 'max' => 3000],
            [
                'user_id',
                'exist',
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
            [
                'task_id',
                'exist',
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'message' => 'Message',
            'date_time' => 'Date Time',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ChatMessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChatMessagesQuery(get_called_class());
    }
}
