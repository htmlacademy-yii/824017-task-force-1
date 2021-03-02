<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class AccomplishAction extends AbstractAction {
	
	public function getInternalActionName()
	{
		return 'Выполнено';
	}
	public function getDisplayingActionName()
	{
		return 'to accomplish';
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, string $currentUserRole): bool
	{
		return customerId === currentUserId ? true : false;
	}
}