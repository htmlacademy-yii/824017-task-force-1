<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

use TaskForce\Exceptions\GivenArgumentException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_EXECUTING = 'executing';
    const STATUS_ACCOMPLISHED = 'accomplished';
    const STATUS_FAILED = 'failed';
    const TO_CANCEL = 'cancel';
    const TO_EXECUTE = 'response';
    const TO_ACCOMPLISH = 'complete';
    const TO_FAIL = 'refuse';

    private string $currentStatus;
    private int $customerId;
    private ?int $executantId;
    
    private array $mapping = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_EXECUTING => 'В работе',
        self::STATUS_ACCOMPLISHED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::TO_CANCEL => 'Отменить',
        self::TO_EXECUTE => 'Откликнуться',
        self::TO_ACCOMPLISH => 'Выполнено',
        self::TO_FAIL => 'Отказаться'
    ];
    private array $statusChanges = [
        self::STATUS_NEW => [
            self::TO_CANCEL => self::STATUS_CANCELED,
            self::TO_EXECUTE => self::STATUS_EXECUTING
        ],
        self::STATUS_EXECUTING => [
            self::TO_ACCOMPLISH => self::STATUS_ACCOMPLISHED,
            self::TO_FAIL => self::STATUS_FAILED
        ]
    ];

    public function __construct(int $customerId, ?int $executantId = null, string $status = self::STATUS_NEW)
    {
        $this->executantId = $executantId;
        $this->customerId = $customerId;
        
        if (!in_array($status, [
            self::STATUS_NEW,
            self::STATUS_CANCELED,
            self::STATUS_EXECUTING,
            self::STATUS_ACCOMPLISHED,
            self::STATUS_FAILED
        ], true)) {
            throw new GivenArgumentException("недопустимый статус '$status'");
        }

        $this->currentStatus = $status;
    }

    public function getStatusCausedByAction(string $action): ?string
    {
        $isAbleToChangeCurrentStatus = isset($this->statusChanges[$this->currentStatus]);

        if ($isAbleToChangeCurrentStatus) {

            if (isset($this->statusChanges[$this->currentStatus][$action])) {

                return $this->statusChanges[$this->currentStatus][$action];
            }
        }

        return null;
    }

    public function getAvailableAction(int $userId, ?string $userRole = null): ?AbstractAction
    {
        if ($userRole && !in_array($userRole, ['executant', 'customer'])) {
            throw new GivenArgumentException("недопустимая роль '$userRole'");
        }

        $availableAction = null;

        switch ($this->currentStatus) {
            case self::STATUS_NEW:
                $actions = [new ExecuteAction, new CancelAction];
                break;
            case self::STATUS_EXECUTING:
                $actions = [new FailAction, new AccomplishAction];
                break;
            default:
                return null;
        }

        foreach ($actions as $action) {

            if ($action->canUserAct($this->customerId, $this->executantId, $userId, $userRole)) {
                $availableAction = $action;
            }
        }
        
        return $availableAction;
    }

    public function getMappingElementValue(string $actionOrStatusName): ?string
    {
        return $this->mapping[$actionOrStatusName] ?? null;
    }
}
