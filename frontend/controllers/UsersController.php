<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\SearchUserForm;
use frontend\models\Users;
use yii\helpers\ArrayHelper;
use frontend\models\Specializations;
use frontend\controllers\SecuredController;
use Yii;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $specializations = ArrayHelper::map(Specializations::find()->asArray()->all(), 'id', 'name');

        $query = Users::find()->select(['users.*', 'AVG(rate) as rating', 'COUNT(rate) as finished_tasks_count', 'COUNT(comment) as comments_count'])->joinWith('specializations')->joinWith('reviews0')->joinWith('tasks0')->where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->asArray();

        $searchUserForm = new SearchUserForm;

        $request = Yii::$app->request;

        switch ($request->method) {
            case 'GET':
                $id = $request->get('specialization_id');

                if (key_exists($id, $specializations)) {
                    $searchUserForm->searchedSpecializations[$id] = $id;
                    $query->andWhere(['specializations.id' => $searchUserForm->searchedSpecializations[$id]]);
                }

                break;

            case 'POST':
                if ($request->post('SearchUserForm')['searchedName']) {
                    $searchUserForm->searchedName = $request->post('SearchUserForm')['searchedName'];
                    $query->andWhere(['like', 'users.name', $searchUserForm->searchedName]);
                } else {
                    $searchUserForm->load($request->post());
                    $query->andFilterWhere(['specializations.id' => $searchUserForm->searchedSpecializations]);
                    $query->andFilterWhere(['>', 'favorite_count', $searchUserForm->isFavorite]);
                    $query->andFilterHaving(['>', 'comments_count', $searchUserForm->hasReviews]);
                
                    if ($searchUserForm->isFreeNow) {
                        $query->andWhere(['tasks.id' => null]);
                    }

                    if ($searchUserForm->isOnline) {
                        $query->andWhere(['between', 'last_activity', strftime("%F %T", strtotime("-30 min")), strftime("%F %T")]);
                    }
                }

                break;
        }  

        $users = $query->all();

        return $this->render('index', ['users' => $users, 'searchUserForm' => $searchUserForm, 'specializations' => $specializations]);
    }

    public function actionView($id = null)
    {
        $user = Users::findOne($id);
        if (!$user) { 
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('view', ['user' => $user]);
    }

    /*public function actionTest($id = null)
    {
        $task = Users::findOne($id);

        return $this->render('test', ['user' => $user]);
    }*/
}