<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\FailForm;
use frontend\models\task\TaskService;
use yii\web\Response;

class FailAction extends BaseAction
{
    /** @var FailForm $form */
    private FailForm $form;

    public function __construct($id, $controller, FailForm $form, TaskService $service)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

    public function run(): Response
    {
        $this->service->fail($this->form);

        return $this->controller
            ->redirect(['tasks/view', 'id' => $this->form->task_id]);
    }
}
