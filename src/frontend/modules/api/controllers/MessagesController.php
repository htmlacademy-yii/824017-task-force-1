<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use frontend\models\ChatMessages;

/**
 * Контроллер просмотра и отправки сообщений чата.
 */
class MessagesController extends ActiveController
{
    public $modelClass = ChatMessages::class;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => \frontend\modules\api\controllers\actions\messages\IndexAction::class,
                'modelClass' => $this->modelClass,
            ],
            'create' => [
                'class' => \frontend\modules\api\controllers\actions\messages\CreateAction::class,
                'modelClass' => $this->modelClass,
            ],
        ];
    }
}
