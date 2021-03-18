<?php

declare(strict_types = 1);

namespace frontend\controllers;

use TaskForce\Controllers\Task;
use yii\web\Controller;
use frontend\models\Tasks;
//use frontend\models\SearchTasks;
use Yii;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
    	/*$tasks = new Tasks;
        if (Yii::$app->request->getIsPost()) {
        	$tasks->load()
        }*/
        $query = Tasks::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC]);

        $searchModel = (new Tasks);
        //var_dump($searchModel);
        if (Yii::$app->request->getIsPost()) {
        	//var_dump(Yii::$app->request->post());
            $searchModel->load(Yii::$app->request->post());
            //var_dump($searchModel);
            $query->andFilterWhere(['specialization_id' => $searchModel->searchedSpecializations]);
            //var_dump($query);	
        }

        /*if ($params) {
            $this->load($params);

            $query->andFilterWhere(['type_id' => $this->type_id]);
            $query->andFilterWhere(['company_id' => $this->company_id]);

            if ($this->search) {
                $query->orWhere(['like', 'email', $this->search]);
                $query->orWhere(['like', 'name', $this->search]);
                $query->orWhere(['like', 'phone', $this->search]);
            }
        }*/

        //$searchModel 

        $tasks = $query->all();
        //var_dump($tasks);

        return $this->render('index', ['tasks' => $tasks, 'searchModel' => $searchModel]);
    }

    //public function actionSearch()
}
