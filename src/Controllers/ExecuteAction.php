<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

use frontend\models\task\Tasks;
use frontend\models\user\Users;

final class ExecuteAction extends AbstractAction
{
    private const ROLE_EXECUTANT = 'executant';
    private int $taskId;

    public function __construct(int $taskId)
    {
        $this->internalName = Task::TO_EXECUTE;
        $this->displayingName = 'Откликнуться';
        $this->taskId = $taskId;
    }

    public function getInternalName(): string
    {
        return $this->internalName;
    }

    public function getDisplayingName(): string
    {
        return $this->displayingName;
    }

    public function canUserAct(int $customerId, ?int $executantId, int $currentUserId, ?string $currentUserRole): bool
    {
        $task = Tasks::findOne($this->taskId);
        $user = Users::findOne($currentUserId);

        $hasNotRespondedYet = true;

        foreach ($task->responses as $response) {
            if ($response->user_id === $user->id) {
                $hasNotRespondedYet = false;
                break;
            }
        }

        return $currentUserRole === self::ROLE_EXECUTANT
            && $currentUserId !== $customerId
            && $hasNotRespondedYet;
    }
}
