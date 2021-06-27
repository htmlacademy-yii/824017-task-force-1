<?php

return [
    'container' => [
        'definitions' => [
            \yii\web\Request::class                       => \yii\web\Request::class,
            \frontend\models\task\TaskService::class      => \frontend\models\task\TaskService::class,
            \frontend\models\task\TaskSearchForm::class   => \frontend\models\task\TaskSearchForm::class,
            \frontend\models\task\TaskCreatingForm::class => \frontend\models\task\TaskCreatingForm::class,
            \frontend\models\user\UserService::class      => \frontend\models\user\UserService::class,
            \frontend\models\user\UserSearchForm::class   => \frontend\models\user\UserSearchForm::class,
            \frontend\models\user\SignHandler::class      => \frontend\models\user\SignHandler::class,
            \frontend\models\user\SignUpForm::class       => \frontend\models\user\SignUpForm::class,
            \frontend\models\user\LoginForm::class        => \frontend\models\user\LoginForm::class,
        ],
        'singletons' => [],
    ]
];
