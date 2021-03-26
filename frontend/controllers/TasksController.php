<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use frontend\models\Specializations;
use frontend\models\Tasks;
use Yii;

class TasksController extends Controller
{
    public function actionIndex() //подскажи, плиз, нужно ли здесь проставлять тип возращаемого значения для соблюдения критерия Д7 ?
    {
        $specializations = ArrayHelper::map(Specializations::getAll(), 'id', 'name');
        $searchForm = new Tasks(['scenario' => Tasks::SCENARIO_SEARCH]);
        $tasks = $searchForm->search($specializations, Yii::$app->request);

        return $this->render('index', [
            'tasks' => $tasks,
            'searchForm' => $searchForm,
            'specializations' => $specializations
        ]);
    }
}
