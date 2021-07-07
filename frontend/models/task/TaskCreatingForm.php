<?php

declare(strict_types = 1);

namespace frontend\models\task;

use Yii;
use frontend\models\specializations\Specializations;
use frontend\models\cities\Cities;
use frontend\models\user\Users;
use yii\helpers\ArrayHelper;

class TaskCreatingForm extends Model
{
    public $name;
    public $description;
    public $specialization_id;
    public $payment;
    public $deadline_date;
    public $address;
    public $latitude;
    public $longitude;

    private array $specializations;

    /**
     * Возвращает массив существующих специализаций.
     *
     * Проверяет было ли присвоено значение свойству $specializations. Если нет,
     * то при помощи метода модели Specializations получает массив специализаций,
     * при помощи ArrayHelper'а изменяет полученный массив, присваивает его свойству
     * $specializations и возвращает значение этого свойства. Возвращаемый массив
     * используется в дропдауне данной формы.
     *
     * @return array Массив существующих специализаций.
     */
    public function getSpecializations(): array
    {
        if (!isset($this->specializations)) {
            $this->specializations = ArrayHelper::map(Specializations::getAll(), 'id', 'name');
        }
        
        return $this->specializations;
    }

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
            ['name', 'required', 'message' => 'Кратко опишите суть работы'],
            ['description', 'required', 'message' => 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться'],
            ['specialization_id', 'required', 'message' => 'Выберите категорию'],
            ['name', 'match', 'pattern' => "/(?=(.*[^ ]){10,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            /*['description', 'match', 'pattern' => "/(?=(.*[^ ]){30,})/", 'message' => 'Длина поля «{attribute}» должна быть не меньше 30 не пробельных символов'],*/
            [['name', 'description', 'specialization_id', 'payment', 'deadline_date', 'address'], 'safe'],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specializations::class,
                'targetAttribute' => ['specialization_id' => 'id'],
                'message' => 'Такой специализации не существует'
            ],
            ['payment', 'integer', 'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
                'tooSmall' => 'Значение должно быть целым положительным числом'
            ],
            ['deadline_date', 'date', 'format' => 'yyyy*MM*dd', 'message' => 'Необходимый формат «гггг.мм.дд»']
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
            'address' => 'Локация'
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery|ChatMessagesQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[NotificationsHistories]].
     *
     * @return \yii\db\ActiveQuery|NotificationsHistoryQuery
     */
    public function getNotificationsHistories()
    {
        return $this->hasMany(NotificationsHistory::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponsesQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskHelpfulFiles]].
     *
     * @return \yii\db\ActiveQuery|TaskHelpfulFilesQuery
     */
    public function getTaskHelpfulFiles()
    {
        return $this->hasMany(TaskHelpfulFiles::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executant]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getExecutant()
    {
        return $this->hasOne(Users::className(), ['id' => 'executant_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery|SpecializationsQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(Specializations::className(), ['id' => 'specialization_id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }
}
