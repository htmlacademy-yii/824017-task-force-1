<?php

namespace frontend\models;

use Yii;

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
    public const SCENARIO_SEARCH = 'search';

    public $searchedSpecializations;
    public $isFreeNow;
    public $isOnline;
    public $hasReviews;
    public $isFavorite;
    public $searchedName;


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
            [['city_id', 'role', 'name', 'email', 'password', 'favorite_count', 'failure_count'], 'required'],
            [['city_id', 'favorite_count', 'failure_count'], 'integer'],
            [['signing_up_date', 'birthday', 'last_activity_date_time'], 'safe'],
            [['role'], 'string', 'max' => 50],
            [['name', 'email'], 'string', 'max' => 300],
            [['password', 'description'], 'string', 'max' => 3000],
            [['avatar'], 'string', 'max' => 1000],
            [['phone', 'skype', 'telegram'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 500],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['searchedSpecializations', 'isFreeNow', 'isOnline', 'hasReviews', 'isFavorite', 'searchedName'], 'safe', 'on' => self::SCENARIO_SEARCH]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'signing_up_date' => 'Signing Up Date',
            'role' => 'Role',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
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
        return $this->hasMany(NotificationsHistory::className(), ['recipient_id' => 'id']);
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
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
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
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UsersAccomplishedTasksPhotos]].
     *
     * @return \yii\db\ActiveQuery|UsersAccomplishedTasksPhotoQuery
     */
    public function getUsersAccomplishedTasksPhotos()
    {
        return $this->hasMany(UsersAccomplishedTasksPhoto::className(), ['user_id' => 'id']);
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

    final public function getExecutants($specializations, $request)
    {
        $query = self::find()->select(['users.*', 'AVG(rate) as rating', 'COUNT(rate) as finished_tasks_count', 'COUNT(comment) as comments_count'])->joinWith('specializations')->joinWith('reviews0')->joinWith('tasks0')->where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->asArray();

        $this->scenario = $request ? self::SCENARIO_SEARCH : self::SCENARIO_DEFAULT;

        if ($this->scenario === self::SCENARIO_SEARCH && $request->isGet) {
            
            $id = $request->get('specialization_id');

            if (key_exists($id, $specializations)) {
                $this->searchedSpecializations[$id] = $id;
                $query->andWhere(['specializations.id' => $this->searchedSpecializations[$id]]);
            }

        } elseif ($this->scenario === self::SCENARIO_SEARCH && $request->isPost) {
    
            if ($request->post('SearchUserForm')['searchedName']) {
                $this->searchedName = $request->post('SearchUserForm')['searchedName'];
                $query->andWhere(['like', 'users.name', $this->searchedName]);
            } else {
                $this->load($request->post());
                $query->andFilterWhere(['specializations.id' => $this->searchedSpecializations]);
                $query->andFilterWhere(['>', 'favorite_count', $this->isFavorite]);
                $query->andFilterHaving(['>', 'comments_count', $this->hasReviews]);
            
                if ($this->isFreeNow) {
                    $query->andWhere(['tasks.id' => null]);
                }

                if ($this->isOnline) {
                    $query->andWhere(['between', 'last_activity', strftime("%F %T", strtotime("-30 min")), strftime("%F %T")]);
                }
            }           
        }  

        $users = $query->all();

        return $users;
    } 
}
