<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\user\UserService;
use yii\base\Action;

class BaseAction extends Action
{
    /** @var UserService $service */
    protected UserService $service;

    public function __construct(
        $id,
        $controller,
        UserService $userService
    ) {
        $this->service = $userService;
        parent::__construct($id, $controller);
    }
}
