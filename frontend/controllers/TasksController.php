<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\TaskService;
use frontend\models\TaskSearchForm;

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
        $tasks = $this->service->getTasks(
            $searchForm = new TaskSearchForm() //а мне первый наставник говорил, что присвоения в условной конструкции - плохая практика. Понимаю, что это не условная конструкция. Но очень похоже не такой случай, хм..
        );

        return $this->render('index', compact('tasks', 'searchForm'));
    }
}
