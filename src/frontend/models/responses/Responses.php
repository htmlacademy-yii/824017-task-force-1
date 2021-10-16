<?php

namespace frontend\models\responses;

use frontend\models\task\TasksQuery;
use frontend\models\user\Users;
use frontend\models\task\Tasks;

use frontend\models\user\UsersQuery;
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
 * @property bool $is_refused
 *
 * @property Users $user
 * @property Tasks $task
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
            [['task_id', 'user_id', 'comment', 'payment', 'is_refused'], 'safe'],
            [['comment'], 'string', 'max' => 3000],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ResponsesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponsesQuery(get_called_class());
    }

    public static function findByUserAndTask(int $userId, int $taskId): array
    {
        return self::find()
            ->where(['user_id' => $userId, 'task_id' => $taskId])->all();
    }

    public function refuse(): bool
    {
        $this->setAttribute('is_refused', 1);

        return $this->save(false);
    }
}
