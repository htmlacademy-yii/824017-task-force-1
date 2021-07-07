<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\user\UserService;
use yii\base\Action;
use yii\di\Container;

class BaseAction extends Action
{
    /** @var Container $container */
    protected Container $container;

    /** @var UserService $service */
    protected UserService $service;

    public function __construct(
        $id,
        $controller,
        UserService $userService,
        Container $container,
        $config = []
    ) {
        $this->container = $container;
        $this->service = $userService;
        parent::__construct($id, $controller, $config);
    }
}
