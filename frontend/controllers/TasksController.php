<?php

declare(strict_types = 1);

namespace frontend\controllers;

use frontend\controllers\SecuredController;
use frontend\models\task\TaskService;
use frontend\models\task\TaskSearchForm;
use Yii;

class TasksController extends SecuredController
{
    private TaskService $service;

    public function init()
    {
        parent::init();
        $this->service = new TaskService($this->request);
    }

    public function actionIndex()
    {
        $searchForm = new TaskSearchForm();
        $tasks = $this->service->getTasks($searchForm);

        return $this->render('index', compact('tasks', 'searchForm'));
    }

    public function actionView(?string $id = null)
    {
        $task = $this->service->getOneTask($id);

        return $this->render('view', ['task' => $task]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
