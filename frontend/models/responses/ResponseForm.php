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
