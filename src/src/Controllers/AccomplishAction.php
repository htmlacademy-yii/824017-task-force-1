<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

final class AccomplishAction extends AbstractAction
{
    public function __construct()
    {
        $this->internalName = Task::TO_ACCOMPLISH;
        $this->displayingName = 'Выполнено';
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
        return $currentUserId === $customerId;
    }
}
