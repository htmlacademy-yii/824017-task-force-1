<?php

declare(strict_types = 1);

namespace frontend\models\task;

use yii\web\Request;
use yii\base\BaseObject;

class TaskService extends BaseObject
{
    private Request $request;

    public function __construct(Request $request, array $config = [])
    {
        parent::__construct($config);
        $this->request = $request;
    }

    public function getTasks(TaskSearchForm $form): ?array
    {
        $this->request->isGet ? $this->getFiltering($form) : $this->postFiltering($form);

        if (array_filter($form->attributes)) {
            return Tasks::findNewTasksByFilters($form);
        }

        return Tasks::findNewTasks();
    }

    public function getOneTask(?string $id = null): Tasks
    {
        $task = Tasks::findOne($id);
        if (!$task) { 
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $task;
    }

    private function getFiltering(TaskSearchForm $form): void
    {
        $id = $this->request->get('specialization_id');

        if (key_exists($id, $form->getSpecializations())) {
            $form->searchedSpecializations[$id] = $id;
        }
    }

    private function postFiltering(TaskSearchForm $form): void
    {
        $form->load($this->request->post());
    }
}