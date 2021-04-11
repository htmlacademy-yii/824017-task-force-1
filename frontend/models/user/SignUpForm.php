<?php

declare(strict_types = 1);

namespace frontend\models\user;

use frontend\models\cities\Cities;
use yii\helpers\ArrayHelper;

class SignUpForm extends \yii\db\ActiveRecord
{
    private array $cities;

    public static function tableName()
    {
        return 'users';
    }

    public function getCities(): array
    {
        if (!isset($this->cities)) {
            $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'name');
        }
        
        return $this->cities;
    }

    public function rules()
    {
        return [
            [['city_id', 'name', 'email', 'password'], 'required', 'message' => "Поле «{attribute}» не может быть пустым"],
            [['city_id'], 'integer', 'message' => "Выбрано не валидное значение «{value}» поля «{attribute}»"],
            [['password'], 'string', 'min' => 8, 'tooShort' =>  "Длина пароля от 8 символов"],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id'], 'message' => "Выбран несуществующий город"],
            [['email'], 'email', 'message' => 'Введите валидный адрес электронной почты'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'message' => "Пользователь с еmail «{value}» уже зарегистрирован"],
            [['city_id', 'name', 'email', 'password'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'city_id' => 'Город проживания',
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'password' => 'Пароль'
        ];
    }
}
