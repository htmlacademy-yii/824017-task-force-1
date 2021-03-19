<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\SearchUserForm;
use frontend\models\Users;
use Yii;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $query = Users::find()->select(['users.*', 'AVG(rate) as rating', 'COUNT(rate) as finished_tasks_count', 'COUNT(comment) as comments_count'])->with('specializations')->joinWith('reviews0')->where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->asArray();

        $searchUserForm = new SearchUserForm;

        if (Yii::$app->request->getIsPost()) {
            $searchUserForm->load(Yii::$app->request->post());

            $query->andFilterWhere(['specialization_id' => $searchUserForm->searchedSpecializations]);
        }


        $users = $query->all();

        return $this->render('index', ['users' => $users, 'searchUserForm' => $searchUserForm]);

        /*$query = Tasks::find()->with('specialization')->joinWith('responses')->where(['status' => Task::STATUS_NEW])->orderBy(['posting_date' => SORT_DESC])->asArray();

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

        return $this->render('index', ['tasks' => $tasks, 'searchTaskForm' => $searchTaskForm]);*/
    }
}