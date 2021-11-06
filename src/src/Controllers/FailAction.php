<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

final class FailAction extends AbstractAction
{
    public function __construct()
    {
        $this->internalName = Task::TO_FAIL;
        $this->displayingName = 'Отказаться';
    }

    public function getInternalName(): string
    {
        return $this->internalName;
    }

    public function getDisplayingName(): string
    {
        return $this->displayingName;
    }

    public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole): bool
    {
        return $currentUserId === $executantId;
    }
}
