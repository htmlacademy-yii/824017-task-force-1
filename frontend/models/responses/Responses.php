<?php

namespace frontend\models\responses;

use frontend\models\user\Users;
use frontend\models\task\Tasks;

use Yii;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property int|null $payment
 * @property string|null $comment
 * @property string $date_time
 *
 * @property User $user
 * @property Task $task
 */
class Responses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id', 'payment'], 'integer'],
            [['task_id', 'user_id', 'comment', 'payment'], 'safe'],
            [['comment'], 'string', 'max' => 3000],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'payment' => 'Payment',
            'comment' => 'Comment',
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
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ResponsesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponsesQuery(get_called_class());
    }
}
