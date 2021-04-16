<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\SignUpForm;
use frontend\models\user\SignUpHandler;
use Yii;
use yii\filters\AccessControl;

class SignUpController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function($rule, $action) {
                    $this->redirect(['tasks/index']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $signUpForm = new SignUpForm;

        if ($signUpForm->load(Yii::$app->request->post())) {
            $signUpHandler = new SignUpHandler($signUpForm);

            if ($signUpHandler->signUp()) {

                return $this->goHome();
            }
        }
        
        return $this->render('index', ['model' => $signUpForm]);
    }
}