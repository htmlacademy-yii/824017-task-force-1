<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\reviews\ReviewForm;
use yii\web\Response;

class AccomplishAction extends BaseAction
{
    public function run(): Response
    {
        $form = new ReviewForm();
        $this->service->accomplish($form);

        return $this->controller->goHome();
    }
}
