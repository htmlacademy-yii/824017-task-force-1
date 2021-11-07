<?php

declare(strict_types=1);

namespace frontend\modules\api\controllers\actions\tasks;

use yii\rest\Action;
use yii\web\User;

/**
 * Отправляет список заданий, назначенных пользователю.
 */
class IndexAction extends Action
{
    /**
     * @return array
     */
    public function run(User $user): array
    {
        return $this->modelClass::findAll(['executant_id' => $user->getId()]);
    }
}
