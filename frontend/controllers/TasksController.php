<?php

declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\task\Tasks;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * TasksController организовывает просмотр заданий и добавление нового задания.
 */
class TasksController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index',
                    'view',
                    'upload',
                    'add',
                    'accomplish',
                    'fail',
                ],
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
                    ],
                    [
                        'actions' => ['accomplish'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $post = $this->request->post();
                            $id = $post['ReviewForm']['task_id'];
                            $taskToBeAccomplished = Tasks::findOne($id);

                            return Yii::$app->user->getIdentity()
                                    ->id === $taskToBeAccomplished->customer_id;
                        }
                    ],
                    [
                        'actions' => ['fail'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $post = $this->request->post();
                            $id = $post['FailForm']['task_id'];
                            $taskToBeFailed = Tasks::findOne($id);

                            return Yii::$app->user->getIdentity()
                                    ->id === $taskToBeFailed->executant_id;
                        }
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
            'add-response' => \frontend\controllers\actions\tasks\AddResponseAction::class,
            'refuse-response' => \frontend\controllers\actions\tasks\RefuseResponseAction::class,
            'start-executing' => \frontend\controllers\actions\tasks\StartExecutingAction::class,
            'accomplish' => \frontend\controllers\actions\tasks\AccomplishAction::class,
            'fail' => \frontend\controllers\actions\tasks\FailAction::class,
            'cancel' => \frontend\controllers\actions\tasks\CancelAction::class,
            'error' => \yii\web\ErrorAction::class,
        ];
    }
}
