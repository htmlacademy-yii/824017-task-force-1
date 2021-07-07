<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\TaskCreatingForm;
use frontend\models\task\TaskService;
use yii\web\Response;

class AddAction extends BaseAction
{
    /** @var TaskCreatingForm $form */
    private TaskCreatingForm $form;

    public function __construct($id, $controller, TaskCreatingForm $form, TaskService $service)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

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
        if ($this->service->add($this->form)) {
            return $this->controller->goHome();
        }

        return $this->controller->render(
            'add',
            ['taskCreatingForm' => $this->form]
        );
    }
}
