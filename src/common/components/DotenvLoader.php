<?php

namespace common\components;

use Dotenv\Dotenv;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class DotenvLoader implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Dotenv::createImmutable(__DIR__ . '/../../')->load();

        $app->setComponents(ArrayHelper::merge($app->getComponents(),
            [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'pgsql:host=postgres;' .
                        'port=' . $_ENV['PG_EXTERNAL_PORT'] . ';' .
                        'dbname=' . $_ENV['POSTGRES_DB'],
                    'username' => $_ENV['POSTGRES_USER'],
                    'password' => $_ENV['POSTGRES_PASSWORD'],
                    'charset' => 'utf8',
                ],
            ]
        ));
    }
}
