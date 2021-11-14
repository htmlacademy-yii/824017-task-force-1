<?php

declare(strict_types=1);

namespace frontend\modules\api\controllers\actions\messages;

use yii\rest\Action;
use yii\web\User;

/**
 * Отправляет список сообщений из переписки по заданию.
 */
class IndexAction extends Action
{
    /**
     * @return array
     */
    public function run(int $task_id, User $user): array
    {
        $messages = $this->modelClass::find()
            ->where(['task_id' => $task_id])
            ->orderBy('date_time ASC')
            ->asArray()->all();

        foreach ($messages ?? [] as $key => $message) {
            $messages[$key]['is_mine'] = $user->getId() === $message['user_id'];
        }

        return $messages;
    }
}
