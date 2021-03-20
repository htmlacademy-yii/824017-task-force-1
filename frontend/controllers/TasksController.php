<?php

declare(strict_types = 1);

namespace frontend\controllers;

use TaskForce\Controllers\Task;
use yii\web\Controller;
use frontend\models\Tasks;
use frontend\models\SearchTaskForm;
use yii\helpers\ArrayHelper;
use frontend\models\Specializations;
use Yii;

class TasksController extends Controller
{
    public function actionIndex() //нужно ли в таких случаях проставлять тип возращаемого значения для соблюдения критерия Д7 ?
    {
    	$specializations = ArrayHelper::map(Specializations::find()->asArray()->all(), 'id', 'name');

        $query = Tasks::find()->with('specialization')->joinWith('responses')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->asArray();

        $searchTaskForm = new SearchTaskForm;

        $request = Yii::$app->request;

        switch ($request->method) {
            case 'GET':
                $id = $request->get('specialization_id');

                if (key_exists($id, $specializations)) {
                    $searchTaskForm->searchedSpecializations[$id] = $id;
                    $query->andWhere(['specialization_id' => $searchTaskForm->searchedSpecializations[$id]]);
                }

                break;

            case 'POST':
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

	            break;
	    }

        $tasks = $query->all();

        return $this->render('index', ['tasks' => $tasks, 'searchTaskForm' => $searchTaskForm, 'specializations' => $specializations]);
    }

    public function view() //нужно ли проставить тип view(int $id)..
    {
        $task = Tasks::findOne($id);
        //var_dump($task);

        return $this->render('view');
    }
}
