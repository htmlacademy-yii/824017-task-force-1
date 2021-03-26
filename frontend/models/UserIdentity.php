<?php

declare(strict_types = 1);

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserIdentity extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    //public $password_repeat;

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /*public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'phone' => 'Номер телефона',
            'company' => 'Название компании',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
        ];
    }*/

    /*public function rules()
    {
        return [
            [['company', 'phone', 'email', 'password', 'password_repeat'], 'safe'],
            [['company', 'phone', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['phone', 'match', 'pattern' => '/^[\d]{11}/i',
                'message' => 'Номер телефона должен состоять из 11 цифр'],
            ['company', 'string', 'min' => 3],
            ['password', 'string', 'min' => 8],
            ['password', 'compare']
        ];
    }*/

}