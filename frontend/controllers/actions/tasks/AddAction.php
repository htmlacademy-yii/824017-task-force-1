<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\TaskCreatingForm;
use yii\web\Response;

class AddAction extends BaseAction
{
    /**
     * Организовывает добавление нового задания.
     *
     * При помощи объекта сервиса добавляет новое задание, передавая аргументом
     * форму добавления задания. Если успешно, перенаправляет на домашнюю
     * страницу. В ином случае отображает форму с ошибками.
     *
     * @return Response|string
     */
    public function run()
    {
        $model = $this->container->get(TaskCreatingForm::class);

        if ($this->service->add($model)) {
            return $this->controller->goHome();
        }

        return $this->controller->render(
            'add',
            ['taskCreatingForm' => $model]
        );
    }
}
