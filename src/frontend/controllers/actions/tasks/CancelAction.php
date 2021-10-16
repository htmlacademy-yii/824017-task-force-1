<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use yii\web\Response;

class CancelAction extends BaseAction
{
    public function run(int $taskId): Response
    {
        $this->service->cancel($taskId);

        return $this->controller->redirect(['tasks/view', 'id' => $taskId]);
    }
}
