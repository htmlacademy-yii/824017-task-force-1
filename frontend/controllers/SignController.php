<?php

declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * SignController организовывает вход/выход пользователя,
 * регистрацию нового пользователя.
 */
class SignController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                'denyCallback' => function ($rule, $action) {
                    if ($action->id === 'logout') {
                       return $this->redirect(['landing/index']);
                    } else {
                        return $this->goHome();
                    }
                }
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'signup' => \frontend\controllers\actions\sign\SignupAction::class,
            'login' => \frontend\controllers\actions\sign\LoginAction::class,
            'logout' => \frontend\controllers\actions\sign\LogoutAction::class,
        ];
    }
}
