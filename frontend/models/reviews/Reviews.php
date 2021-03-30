<?php

namespace frontend\models\reviews;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $adding_date
 * @property int $task_id
 * @property int $customer_id
 * @property int $executant_id
 * @property string $completion
 * @property string|null $comment
 * @property int $rate
 *
 * @property Task $task
 * @property User $customer
 * @property User $executant
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adding_date'], 'safe'],
            [['task_id', 'customer_id', 'executant_id', 'completion', 'rate'], 'required'],
            [['task_id', 'customer_id', 'executant_id', 'rate'], 'integer'],
            [['completion'], 'string'],
            [['comment'], 'string', 'max' => 3000],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['executant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adding_date' => 'Adding Date',
            'task_id' => 'Task ID',
            'customer_id' => 'Customer ID',
            'executant_id' => 'Executant ID',
            'completion' => 'Completion',
            'comment' => 'Comment',
            'rate' => 'Rate',
        ];
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executant]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getExecutant()
    {
        return $this->hasOne(User::className(), ['id' => 'executant_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReviewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewsQuery(get_called_class());
    }
}
