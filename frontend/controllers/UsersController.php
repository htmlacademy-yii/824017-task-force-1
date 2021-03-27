<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\UserService;
use frontend\models\UserSearchForm;

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
        $users = $this->service->getUsers(
            $searchForm = new UserSearchForm()
        );

        return $this->render('index', compact('users', 'searchForm'));
    }
}
