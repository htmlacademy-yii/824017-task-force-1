<?php

declare(strict_types = 1);

namespace frontend\models\task;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use frontend\models\{
    specializations\Specializations,
    cities\Cities,
    user\Users,
};

class TaskCreatingForm extends Model
{
    public $name;
    public $description;
    public $specialization_id;
    public $payment;
    public $deadline_date;
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

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Кратко опишите суть работы'],
            ['description', 'required',
                'message' => 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться'
            ],
            ['specialization_id', 'required', 'message' => 'Выберите категорию'],
            ['name', 'match', 'pattern' => "/(?=(.*[^ ]){10,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            /*['description', 'match', 'pattern' => "/(?=(.*[^ ]){30,})/", 'message' => 'Длина поля «{attribute}» должна быть не меньше 30 не пробельных символов'],*/
            [['name', 'description', 'specialization_id', 'payment', 'deadline_date'], 'safe'],
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

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'specialization_id' => 'Категория',
            'payment' => 'Бюджет',
            'deadline_date' => 'Срок исполнения',
        ];
    }
}
