<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\task\Tasks;

class LandingController extends Controller
{
    public $layout = 'anon';

    public function actionIndex()
    {
        $tasks = Tasks::findLastFourTasks();

        return $this->render('index', ['tasks' => $tasks]);
    }

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
}
