<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'task/view/<id>' => 'tasks/view',
                'user/view/<id>' => 'users/view',
            ],
        ],
        'formatter' => [
            'language' => 'ru',
        ],
    ],
    'timeZone' => 'Europe/Moscow',
    'defaultRoute' => ['tasks/index'],
    'homeUrl' => ['tasks/index'],
];
