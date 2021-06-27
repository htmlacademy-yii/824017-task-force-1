<?php

declare(strict_types=1);

namespace frontend\controllers\actions\landing;

use yii\base\Action;
use frontend\models\task\Tasks;

class IndexAction extends Action
{
    /**
     * Отображает посадочную страницу и 4 последних добавленных задания.
     *
     * @return string
     */
    public function run()
    {
        $tasks = Tasks::findLastFourTasks();

        return $this->controller->render('index', compact('tasks'));
    }
}
