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
                /*'//' => '/',   это правило было в учебнике. Подскажи, плиз, что оно значит? в поисковике не нашел...*/
                'task/view/<id>' => 'tasks/view',
                'user/view/<id>' => 'users/view',
            ],
        ],
    ],
    'defaultRoute' => ['tasks/index'],
    'homeUrl' => ['tasks/index'],
];
