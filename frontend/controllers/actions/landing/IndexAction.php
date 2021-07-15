<?php

declare(strict_types=1);

namespace frontend\controllers\actions\landing;

use frontend\models\task\Tasks;
use yii\base\Action;

class IndexAction extends Action
{
    /**
     * Отображает посадочную страницу и 4 последних добавленных задания.
     *
     * @return string
     */
    public function run(): string
    {
        $tasks = Tasks::findLastFourTasks();

        return $this->controller->render(
            'index',
            compact('tasks')
        );
    }
}
