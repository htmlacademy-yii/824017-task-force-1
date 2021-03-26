<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use frontend\models\Users;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        $id = Yii::$app->user->getId();
        var_dump(Users::findOne($id));
        /*if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->getId();
            $this->user = Users::findOne($id);
        }*/
        
        return parent::beforeAction($action);
    }
}