<?php

declare(strict_types = 1);

namespace frontend\models\task;

use TaskForce\Controllers\Task;
use frontend\models\{
    responses\Responses,
    specializations\Specializations,
    user\Users,
    cities\Cities,
};
use frontend\models\ChatMessages;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $executant_id
 * @property int|null $city_id
 * @property int|null $specialization_id
 * @property string $posting_date
 * @property string $status
 * @property string $name
 * @property string $description
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $payment
 * @property string|null $deadline_date
 * @property string|null $address
 *
 * @property ChatMessages[] $chatMessages
 * @property NotificationsHistory[] $notificationsHistories
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property TaskHelpfulFiles[] $taskHelpfulFiles
 * @property Users $customer
 * @property Users $executant
 * @property Cities $city
 * @property Specializations $specialization
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'specialization_id', 'deadline_date', 'payment', 'executant_id', 'status', 'address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'executant_id' => 'Executant ID',
            'city_id' => 'City ID',
            'specialization_id' => 'Категория',
            'posting_date' => 'Posting Date',
            'status' => 'Status',
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'payment' => 'Бюджет',
            'deadline_date' => 'Срок исполнения',
            'address' => 'Address'
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery|ChatMessagesQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[NotificationsHistories]].
     *
     * @return \yii\db\ActiveQuery|NotificationsHistoryQuery
     */
    public function getNotificationsHistories()
    {
        return $this->hasMany(NotificationsHistory::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponsesQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskHelpfulFiles]].
     *
     * @return \yii\db\ActiveQuery|TaskHelpfulFilesQuery
     */
    public function getTaskHelpfulFiles()
    {
        return $this->hasMany(TaskHelpfulFiles::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::class, ['id' => 'customer_id'])->one();
    }

    /**
     * Gets query for [[Executant]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getExecutant()
    {
        return $this->hasOne(Users::class, ['id' => 'executant_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery|SpecializationsQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(Specializations::class, ['id' => 'specialization_id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }

    final public static function findNewTasksByFilters(TaskSearchForm $form): TasksQuery
    {
        $query = self::find()->with('specialization')->joinWith('responses')->
            where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->
            asArray();

        $query->specializationsFilter($form->searchedSpecializations);
        $query->nameFilter($form->searchedName);

        if ($form->postingPeriod) {
            $query->period($form->postingPeriod);
        }

        if ($form->hasNoResponses) {
            $query->withoutResponses();
        }

        if ($form->hasNoLocation) {
            $query->withoutLocation();
        }

        return $query;
    }

    final public static function findNewTasks(): TasksQuery
    {
        return self::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->
        orderBy(['posting_date' => SORT_DESC])->asArray();
    }

    final public static function findLastFourTasks(): ?array
    {
        return self::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->
        orderBy(['posting_date' => SORT_DESC])->limit(4)->asArray()->all();
    }
}
