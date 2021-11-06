<?php

namespace common\components;

use cyberinferno\yii\phpdotenv\Loader;
use yii\helpers\ArrayHelper;

class DotenvLoader extends Loader
{
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $app->setComponents(ArrayHelper::merge($app->getComponents(),
            [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'pgsql:host=postgres;' .
                        'port=' . getenv('PG_EXTERNAL_PORT') . ';' .
                        'dbname=' . getenv('POSTGRES_DB'),
                    'username' => getenv('POSTGRES_USER'),
                    'password' => getenv('POSTGRES_PASSWORD'),
                    'charset' => 'utf8',
                ],
            ]
        ));
    }
}
