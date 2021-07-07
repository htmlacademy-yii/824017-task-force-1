<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\ResponseForm;

use frontend\models\task\TaskService;
use yii\web\Response;

class AddResponseAction extends BaseAction
{
    /** @var ResponseForm $form */
    private ResponseForm $form;

    public function __construct($id, $controller, ResponseForm $form, TaskService $service)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

    public function run(): Response
    {
        $this->service->addResponse($this->form);

        return $this->controller->redirect([
            'tasks/view',
            'id' => $this->form->task_id
        ]);
    }
}
