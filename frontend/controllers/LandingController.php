<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class LandingController extends Controller
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
        $this->layout = 'anon';

        return $this->render('index');
    }
}