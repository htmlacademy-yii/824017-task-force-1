<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

/**
 * TasksController организовывает просмотр заданий и добавление нового задания.
 */
class TasksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'upload', 'add'],
                'rules' => [
                    [
                        'actions' => ['add', 'upload-file'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user
                                ->getIdentity()->role === 'customer';
                        }
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => \frontend\controllers\actions\tasks\IndexAction::class,
            'view' => \frontend\controllers\actions\tasks\ViewAction::class,
            'upload-file' => \frontend\controllers\actions\tasks\UploadFileAction::class,
            'add' => \frontend\controllers\actions\tasks\AddAction::class,
            'error' => \yii\web\ErrorAction::class,
        ];
    }
}
