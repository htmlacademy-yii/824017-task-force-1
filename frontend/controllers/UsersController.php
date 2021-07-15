<?php

declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * UsersController выполняет действия по отображению
 * списка исполнителей или одного исполнителя.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => \frontend\controllers\actions\users\IndexAction::class,
            'view' => \frontend\controllers\actions\users\ViewAction::class,
        ];
    }
}
