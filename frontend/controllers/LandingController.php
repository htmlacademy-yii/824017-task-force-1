<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\task\Tasks;

/**
 * LandingController отвечает за работу с посадочной страницей.
 */
class LandingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'anon';

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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function($rule, $action) {
                    return $this->goHome();
                },
            ]
        ];
    }

    /**
     * Отображает посадочную страницу и 4 последних добавленных задания.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tasks = Tasks::findLastFourTasks();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
