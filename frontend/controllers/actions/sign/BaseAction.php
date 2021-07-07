<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\user\SignHandler;
use yii\base\Action;
use yii\di\Container;

class BaseAction extends Action
{
    protected const ANON_PAGE_ROUTE = 'landing/index';

    /** @var Container $container */
    protected Container $container;

    /** @var SignHandler $signHandler */
    protected SignHandler $signHandler;

    public function __construct(
        $id,
        $controller,
        SignHandler $signHandler,
        Container $container,
        $config = []
    ) {
        $this->container = $container;
        $this->signHandler = $signHandler;
        parent::__construct($id, $controller, $config);
    }
}
