<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;

use yii\web\NotFoundHttpException;
use frontend\models\Tasks;
use frontend\models\SearchTaskForm;
use yii\helpers\ArrayHelper;
use frontend\models\Specializations;
use frontend\controllers\SecuredController;
use Yii;

use frontend\models\task\TaskService;
use frontend\models\task\TaskSearchForm;


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
