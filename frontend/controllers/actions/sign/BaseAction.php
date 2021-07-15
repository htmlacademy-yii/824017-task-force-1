<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\user\SignHandler;
use yii\base\Action;

class BaseAction extends Action
{
    protected const ANON_PAGE_ROUTE = 'landing/index';

    /** @var SignHandler $signHandler */
    protected SignHandler $signHandler;

    public function __construct(
        $id,
        $controller,
        SignHandler $signHandler
    ) {
        $this->signHandler = $signHandler;
        parent::__construct($id, $controller);
    }
}
