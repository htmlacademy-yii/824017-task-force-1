<?php

declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * LandingController отвечает за работу с посадочной страницей.
 */
class LandingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'anon';

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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goHome();
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => \frontend\controllers\actions\landing\IndexAction::class,
        ];
    }
}
