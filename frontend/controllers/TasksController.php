<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\task\TaskService;
use frontend\models\task\TaskSearchForm;

class TasksController extends Controller
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

    public function actionView($id = null)
    {
        $task = Tasks::findOne($id);
        if (!$task) { 
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('view', ['task' => $task]);
    }
}
