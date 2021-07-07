<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\Tasks;
use yii\web\Response;
use TaskForce\Controllers\Task;

class StartExecutingAction extends BaseAction
{
    public function run(int $taskId, int $executantId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status = Task::STATUS_EXECUTING;
        $task->executant_id = $executantId;
        $task->save(false);

        return $this->controller->goHome();
    }
}
