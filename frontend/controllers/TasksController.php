<?php

declare(strict_types = 1);

namespace frontend\controllers;

use TaskForce\Controllers\Task;
use yii\web\Controller;
use frontend\models\Tasks;
use frontend\models\SearchTaskForm;
use Yii;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $query = Tasks::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC]);

        $searchTaskForm = (new SearchTaskForm);
        //var_dump($searchTaskForm);
        if (Yii::$app->request->getIsPost()) {
        	//var_dump(Yii::$app->request->post());
            $searchTaskForm->load(Yii::$app->request->post());
            //var_dump($searchTaskForm);
            $query->andFilterWhere(['specialization_id' => $searchTaskForm->searchedSpecializations]);
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

        //var_dump($searchTaskForm);

        $tasks = $query->all();
        //var_dump($tasks);

        return $this->render('index', ['tasks' => $tasks, 'searchTaskForm' => $searchTaskForm]);
    }

    //public function actionSearch()
}
