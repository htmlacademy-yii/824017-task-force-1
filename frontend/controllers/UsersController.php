<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use frontend\models\Users;
use frontend\models\Specializations;
use Yii;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $specializations = ArrayHelper::map(Specializations::getAll(), 'id', 'name');
        $searchForm = new Users(['scenario' => Users::SCENARIO_SEARCH]);
        $users = $searchForm->search($specializations, Yii::$app->request);

        return $this->render('index', [
            'users' => $users,
            'searchForm' => $searchForm,
            'specializations' => $specializations
        ]);
    }
}