<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\Responses;
use yii\web\{NotFoundHttpException, Response};

class RefuseResponseAction extends BaseAction
{
    public function run(int $responseId): Response
    {
        $response = Responses::findOne($responseId);

        if ($response === null) {
            throw new NotFoundHttpException(
                "Отклик с id '$responseId', который вы "
                . "хотите отклонить, не существует."
            );
        }

        $response->refuse();

        return $this->controller->redirect([
            'tasks/view',
            'id' => $response->task_id
        ]);
    }
}
