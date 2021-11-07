<?php

namespace frontend\modules\api\controllers;

use frontend\models\task\Tasks;
use yii\rest\ActiveController;

/**
 * Контроллер просмотра заданий для мобильного приложения.
 */
class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => \frontend\modules\api\controllers\actions\tasks\IndexAction::class,
                'modelClass' => $this->modelClass,
            ],
        ];
    }
}
