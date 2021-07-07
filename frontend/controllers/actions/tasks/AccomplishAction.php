<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\reviews\ReviewForm;
use frontend\models\task\TaskService;
use yii\web\Response;

class AccomplishAction extends BaseAction
{
    /** @var ReviewForm $form */
    private ReviewForm $form;

    public function __construct($id, $controller, ReviewForm $form, TaskService $service)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

    public function run(): Response
    {
        $this->service->accomplish($this->form);

        return $this->controller->goHome();
    }
}
