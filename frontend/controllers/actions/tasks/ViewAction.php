<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use yii\web\NotFoundHttpException;

class ViewAction extends BaseAction
{
    /**
     * Отображает одно задание по его ID.
     *
     * Обращается к объекту свойства $service за получением объекта
     * задания, передовая аргументом ID задания.
     *
     * @param  int $id
     *
     * @throws NotFoundHttpException Если задание с переданным id не
     * было найдено.
     *
     * @return string
     */
    public function run(int $id)
    {
        $task = $this->service->getOneTask($id);

        if (!$task) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->controller->render('view', compact('task'));
    }
}
