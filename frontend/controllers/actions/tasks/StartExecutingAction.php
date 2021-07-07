<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\Tasks;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use TaskForce\Controllers\Task;

class StartExecutingAction extends BaseAction
{
    public function run(int $taskId, int $executantId): Response
    {
        $task = Tasks::findOne($taskId);

        if ($task === null) {
            throw new NotFoundHttpException("Задание с id '$taskId', которое вы хотите поручить исполнителю, не существует");
        }

        $task->setAttributes([
            'status' => Task::STATUS_EXECUTING,
            'executant_id' => $executantId
        ]);
        $task->save(false);

        return $this->controller->goHome();
    }
}
