<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;
use frontend\models\user\SignUpForm;
use frontend\models\user\SignHandler;
use yii\filters\AccessControl;

class SignController extends Controller
{
    private SignHandler $signHandler;
    
    public function init()
    {
        parent::init();
        $this->signHandler = new SignHandler();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function($rule, $action) {
                    if ($action->actionMethod === 'actionLogout') {

                       return $this->redirect(['landing/index']);
                    } else {

                        return $this->goHome();
                    }
                }
            ]
        ];
    }

    public function actionSignup()
    {
        $signupForm = new SignupForm;

        if ($signupForm->load(Yii::$app->request->post())) {

            if ($this->signHandler->signup($signupForm)) {

                return $this->goHome();
            }
        }
        
        return $this->render('index', ['model' => $signupForm]);
    }

    public function actionLogout()
    {
        $this->signHandler->logout();

        return $this->redirect(['landing/index']);
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if ($loginForm->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($loginForm);
            }

            if ($this->signHandler->login($loginForm)) {

                return $this->goHome();
            }
        }

        return $this->redirect(['landing/index']);
    }
}