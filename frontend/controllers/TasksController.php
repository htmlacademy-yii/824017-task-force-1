<?php

declare(strict_types = 1);

namespace frontend\controllers;

use TaskForce\Controllers\Task;
use yii\web\Controller;
use frontend\models\Tasks;
use Yii;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
    	/*$tasks = new Tasks;
        if (Yii::$app->request->getIsPost()) {
        	$tasks->load()
        }*/

        $searchModel = (new Tasks);
        if (Yii::$app->request->getIsPost()) {
            $searchModel->load();
        }

        

        $tasks = Tasks::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->asArray()->all();

        return $this->render('index', ['tasks' => $tasks]);
    }

    public function actionSearch()
}
