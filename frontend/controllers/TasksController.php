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
        $query = Tasks::find()->with('specialization')->joinWith('responses')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->asArray();

        $searchTaskForm = new SearchTaskForm;
        
        if (Yii::$app->request->getIsPost()) {
            $searchTaskForm->load(Yii::$app->request->post());

            $query->andFilterWhere(['specialization_id' => $searchTaskForm->searchedSpecializations]);
            $query->andFilterWhere(['between', 'posting_date', strftime("%F %T", strtotime("-1 $searchTaskForm->postingPeriod")), strftime("%F %T")]);
            $query->andFilterWhere(['like', 'name', $searchTaskForm->searchedName]);

            if ($searchTaskForm->hasNoResponses) { //тут  же не нарушается критерия про инициализацию?
                $query->andWhere(['responses.id' => null]);
            }

            if ($searchTaskForm->hasNoLocation) {
                $query->andWhere(['latitude' => null]);
            }    
        }

        $tasks = $query->all();

        return $this->render('index', ['tasks' => $tasks, 'searchTaskForm' => $searchTaskForm]);
    }
}
