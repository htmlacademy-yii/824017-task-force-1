<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Users;

class UsersController extends Controller
{
    public function actionIndex(): string
    {
        $users = Users::getExecutantsByDate();

        return $this->render('index', ['users' => $users]);
    }
}