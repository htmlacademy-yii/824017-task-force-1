<?php

namespace frontend\models\notifications\history;

use Yii;

/**
 * This is the model class for table "notifications_history".
 *
 * @property int $id
 * @property int $recipient_id
 * @property int $task_id
 * @property string $event_type
 * @property int $is_shown
 * @property string $date_time
 *
 * @property User $recipient
 * @property Task $task
 */
class NotificationsHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipient_id', 'task_id', 'event_type', 'is_shown'], 'required'],
            [['recipient_id', 'task_id', 'is_shown'], 'integer'],
            [['event_type'], 'string'],
            [['date_time'], 'safe'],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient_id' => 'Recipient ID',
            'task_id' => 'Task ID',
            'event_type' => 'Event Type',
            'is_shown' => 'Is Shown',
            'date_time' => 'Date Time',
        ];
    }

    /**
     * Gets query for [[Recipient]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
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
     * @return NotificationsHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsHistoryQuery(get_called_class());
    }
}
