<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\TaskService;
use yii\base\Action;
use yii\di\Container;

class BaseAction extends Action
{
    /** @var Container $container */
    protected Container $container;

    /** @var TaskService $service */
    protected TaskService $service;

    public function __construct(
        $id,
        $controller,
        TaskService $taskService,
        Container $container,
        $config = []
    ) {
        $this->container = $container;
        $this->service = $taskService;
        parent::__construct($id, $controller, $config);
    }
}
