<?php

declare(strict_types = 1);

namespace frontend\models\user;

use frontend\models\{
    specializations\Specializations,
    reviews\Reviews,
    task\Tasks,
    cities\Cities,
};

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $city_id
 * @property string $signing_up_date
 * @property string $role
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string|null $birthday
 * @property string|null $description
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int $favorite_count
 * @property int $failure_count
 * @property string|null $address
 * @property string $last_activity_date_time
 *
 * @property ChatMessage[] $chatMessages
 * @property NotificationsHistory[] $notificationsHistories
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserSpecialization[] $userSpecializations
 * @property Specialization[] $specializations
 * @property City $city
 * @property UsersAccomplishedTasksPhoto[] $usersAccomplishedTasksPhotos
 * @property UsersOptionalSetting $usersOptionalSetting
 */
class Users extends \yii\db\ActiveRecord
{
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_EXECUTANT = 'executant';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'name', 'email', 'password'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'Город проживания',
            'signing_up_date' => 'Signing Up Date',
            'role' => 'Role',
            'name' => 'Ваше имя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'avatar' => 'Avatar',
            'birthday' => 'Birthday',
            'description' => 'Description',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'favorite_count' => 'Favorite Count',
            'failure_count' => 'Failure Count',
            'address' => 'Address',
            'last_activity_date_time' => 'Last Activity Date Time',
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery|ChatMessageQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[NotificationsHistories]].
     *
     * @return \yii\db\ActiveQuery|NotificationsHistoryQuery
     */
    public function getNotificationsHistories()
    {
        return $this->hasMany(
            NotificationsHistory::className(),
            ['recipient_id' => 'id']
        );
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponseQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getCustomerReviews()
    {
        return $this->hasMany(Reviews::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getExecutantReviews()
    {
        return $this->hasMany(Reviews::className(), ['executant_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getExecutantTasks()
    {
        return $this->hasMany(Tasks::className(), ['executant_id' => 'id']);
    }

    /**
     * Gets query for [[UserSpecializations]].
     *
     * @return \yii\db\ActiveQuery|UserSpecializationQuery
     */
    public function getUserSpecializations()
    {
        return $this->hasMany(UserSpecialization::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Specializations]].
     *
     * @return \yii\db\ActiveQuery|SpecializationQuery
     */
    public function getSpecializations()
    {
        return $this->hasMany(Specializations::className(), ['id' => 'specialization_id'])->viaTable('user_specialization', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UsersAccomplishedTasksPhotos]].
     *
     * @return \yii\db\ActiveQuery|UsersAccomplishedTasksPhotoQuery
     */
    public function getUsersAccomplishedTasksPhotos()
    {
        return $this->hasMany(UsersAccomplishedTasksPhotos::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersOptionalSetting]].
     *
     * @return \yii\db\ActiveQuery|UsersOptionalSettingQuery
     */
    public function getUsersOptionalSetting()
    {
        return $this->hasOne(UsersOptionalSetting::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    final public static function findExecutantsByFilters(UserSearchForm $form): ?array
    {
        $query = self::find()->select([
            'users.*',
            'AVG(rate) as rating',
            'COUNT(rate) as finished_tasks_count',
            'COUNT(comment) as comments_count'
        ])->joinWith('specializations')->joinWith('executantReviews')->joinWith('executantTasks')->
        where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->
        asArray();

        if ($form->searchedName) {

            foreach ($form as $attribute => $value) {

                if ($attribute !== 'searchedName') {
                    unset($form[$attribute]);
                }
            }
            $query->nameFilter($form->searchedName);

        } else {
            $query->specializationsFilter($form->searchedSpecializations);
            $query->nameFilter($form->searchedName);
            $query->favoriteFilter($form->isFavorite);

            if ($form->isFreeNow) {
                $query->freeNow();
            }

            if ($form->isOnline) {
                $query->online();
            }

            $query->withReviewsFilter($form->hasReviews);
        }

        return $query->all();
    }

    final public static function findExecutants(): ?array
    {
        $query = self::find()->select([
            'users.*',
            'AVG(rate) as rating',
            'COUNT(rate) as finished_tasks_count',
            'COUNT(comment) as comments_count'
        ])->joinWith('specializations')->joinWith('executantReviews')->joinWith('executantTasks')->
        where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->
        asArray();

        return $query->all();
    }
}
