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
    public function actionIndex()
    {
        $query = Tasks::find()->with('specialization')->joinWith('responses')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->asArray()/*->all()*/;
        //var_dump($query);

        $searchTaskForm = (new SearchTaskForm);
        //var_dump($searchTaskForm);
        if (Yii::$app->request->getIsPost()) {
        	//var_dump(Yii::$app->request->post());
            $searchTaskForm->load(Yii::$app->request->post());
            //var_dump($searchTaskForm);
            $query->andFilterWhere(['specialization_id' => $searchTaskForm->searchedSpecializations]);

            if ($searchTaskForm->hasNoResponses) { //тут  же не нарушается критерия про инициализацию?
            	 $query->andWhere(['responses.id' => null]);
            }
            if ($searchTaskForm->hasNoLocation) {
            	 $query->andWhere(['tasks.latitude' => null]);
            }

        	switch ($searchTaskForm->postingPeriod) {
        		case false:
        			break;
        		
        		default:
        			break;
        	}
        	$query->andWhere(['posting_date' => null]  );
            }

            //$query->andFilterWhere(['responses' => $searchTaskForm->hasNoResponses]);
            //->andWhere(['responses.id' => null])
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
