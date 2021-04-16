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

use frontend\models\user\UserService;
use frontend\models\user\UserSearchForm;


class UsersController extends SecuredController
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

    public function actionView(?string $id = null)
    {
        $user = $this->service->getOneUser($id);

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
