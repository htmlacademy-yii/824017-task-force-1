<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;

class UserController extends Controller
{
    public $layout = 'anon';

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['landing/index']);
    }

    /*public function actionProfile()
    {
        if ($id = Yii::$app->user->getId()) {
            $user = User::findOne($id);

            print($user->email);
        }
    }*/

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());
            
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                $user = $loginForm->user;
                Yii::$app->user->login($user);

                return $this->goHome();
            }
        }

        return $this->redirect(['landing/index']);
    }
}