<?php

return [
    'bootstrap' => [
        [
            'class' => 'common\components\DotenvLoader',
        ],
    ],
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['messages' => 'api/messages'],
                    'patterns' => [
                        'GET'  => 'index',
                        'POST' => 'create',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['tasks' => 'api/tasks'],
                    'patterns' => [
                        'GET'  => 'index'
                    ]
                ],
            ],
        ],
        'formatter' => [
            'language' => 'ru',
            'thousandSeparator' => ' '
        ],
    ],
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU'
];
