<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\ResponseForm;
use yii\web\Response;

class AddResponseAction extends BaseAction
{
    public function run(): Response
    {
        $form = $this->container->get(ResponseForm::class);
        $this->service->addResponse($form);

        return $this->controller->redirect([
            'tasks/view',
            'id' => $form->task_id
        ]);
    }
}
