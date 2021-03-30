<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\user\UserService;
use frontend\models\user\UserSearchForm;
use frontend\models\user\Users;

class UsersController extends Controller
{
    private UserService $service;

    public function init()
    {
        parent::init();
        $this->service = new UserService($this->request);
    }

    public function actionIndex()
    {
        $searchForm = new UserSearchForm();
        $users = $this->service->getUsers($searchForm);

        return $this->render('index', compact('users', 'searchForm'));
    }

    public function actionView($id = null)
    {
        $user = Users::findOne($id);
        if (!$user || $user->role !== 'executant') { 
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('view', ['user' => $user]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
