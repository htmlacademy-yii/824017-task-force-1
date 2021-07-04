<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\FailForm;
use yii\web\Response;

class FailAction extends BaseAction
{
    public function run(): Response
    {
        $form = new FailForm();
        $this->service->fail($form);

        return $this->controller
            ->redirect(['tasks/view', 'id' => $form->task_id]);
    }
}
