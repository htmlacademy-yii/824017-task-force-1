<?php

declare(strict_types = 1);

namespace frontend\models;
use yii\base\Model;
use frontend\models\UserIdentity;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    public function attributeLabels()
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'safe'],
            [['email', 'password'], 'required', 'message' => "Поле «{attribute}» не может быть пустым"],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Вы ввели неверный email/пароль');
            }
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserIdentity::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}