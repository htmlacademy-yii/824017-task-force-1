<?php

declare(strict_types = 1);

namespace frontend\models;

use frontend\models\TaskSearchForm;
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
        switch ($this->request->method) {
            case 'GET':
                $id = $this->request->get('specialization_id');

                if (key_exists($id, $form->getSpecializations())) {
                    $form->searchedSpecializations[$id] = $id;
                } 

                break;

            case 'POST':
                $form->load($this->request->post());

                break;
        }

        if (array_filter($form->attributes)) {
            return Tasks::findNewTasksByFilters($form);
        }

        return Tasks::findNewTasks();
    }
}