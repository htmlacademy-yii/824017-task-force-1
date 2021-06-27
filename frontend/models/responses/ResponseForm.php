<?php

namespace frontend\models\responses;

class ResponseForm extends \yii\db\ActiveRecord
{
    public $user_id;
    public $task_id;
    public $comment;
    public $payment;

    public static function tableName()
    {
        return 'responses';
    }

    public function rules()
    {
        return [
            /*['user_id', 'unique',
                 'filter' => ['task_id' => 1 как сделать чтобы сюда динамически добавлялось значение аттрибута task_id, Кирилл, хелп, плиз! $this->task_id дает null
            ],
            'message' => 'Вы уже откликались на это задание'],*/
            ['payment', 'integer', 'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
                'tooSmall' => 'Значение должно быть целым положительным числом'],
            [['payment', 'comment', 'task_id'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'payment' => 'Ваша цена',
            'comment' => 'Комментарий',
        ];
    }
}
