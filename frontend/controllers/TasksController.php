<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\responses\Responses;
use frontend\models\responses\ResponseForm;
use frontend\models\reviews\ReviewForm;
use frontend\models\FailForm;
use TaskForce\Controllers\Task;
use Yii;

/**
 * TasksController организовывает просмотр заданий и добавление нового задания.
 */
class TasksController extends Controller
{

    /**
     * {@inheritdoc}
     */


    public function actionAddResponse()
    {
        $form = new ResponseForm;
        $this->service->addResponse($form);    

        return $this->actionView($form->task_id);
    }

    public function actionUploadFile()
    {
        $file = UploadedFile::getInstanceByName('Attach');
        $path = '/uploads/' . uniqid() . '.' . $file->extension;
        $file->saveAs('@webroot' . $path);

        $session = Yii::$app->session;
        
        if (isset($session['paths'])) {
            $paths = $session['paths'];
        } else {
            $paths = [];
        }

        $paths[] = $path;
        $session['paths'] = $paths;
    }

    public function actionRefuseResponse(string $responseId)
    {
        $response = Responses::findOne($responseId);
        $response->is_refused = 1;
        $response->save(false);
        return $this->actionView((string) $response->task_id);
    }

    public function actionStartExecuting(string $taskId, string $executantId)
    {
        $task = Tasks::findOne($taskId);

        $task->status = Task::STATUS_EXECUTING;
        $task->executant_id = $executantId;
        $task->save(false);

        return $this->goHome();
    }

    public function actionAccomplish()
    {
        $form = new ReviewForm;
        $this->service->accomplish($form);

        return $this->goHome();
    }

    public function actionFail()
    {
        $form = new FailForm;
        $this->service->fail($form);

        return $this->actionView($form->task_id);
    }

    public function actionCancel(string $task_id)
    {
        $this->service->cancel($task_id);

        return $this->actionView($task_id);
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'upload', 'add', 'accomplish', 'fail'],
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

                            return $this->user->id === $taskToBeAccomplished->customer_id;
                        }
                    ],
                    [
                        'actions' => ['fail'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $post = $this->request->post();
                            $id = $post['FailForm']['task_id'];
                            $taskToBeFailed = Tasks::findOne($id);

                            return $this->user->id === $taskToBeFailed->executant_id;
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
            'error' => \yii\web\ErrorAction::class,
        ];
    }
}
