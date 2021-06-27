<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

final class ExecuteAction extends AbstractAction
{
    private const ROLE_EXECUTANT = 'executant';
    
    public function __construct()
    {
        $this->internalName = Task::TO_EXECUTE;
        $this->displayingName = 'Откликнуться';
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
        return $currentUserRole === self::ROLE_EXECUTANT && $currentUserId !== $customerId;
    }
}
