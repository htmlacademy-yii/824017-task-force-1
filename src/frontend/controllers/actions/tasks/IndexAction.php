<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\{TaskSearchForm, TaskService};

class IndexAction extends BaseAction
{
    /** @var TaskSearchForm $form */
    private TaskSearchForm $form;

    public function __construct(
        $id,
        $controller,
        TaskSearchForm $form,
        TaskService $service
    ) {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

    /**
     * Организовывает просмотр новых заданий.
     *
     * Обращается к объекту свойства $service за получением провайдера данных,
     * передовая аргументом модель формы поиска заданий.
     *
     * @return string
     */
    public function run(): string
    {
        $dataProvider = $this->service->getDataProvider($this->form);

        return $this->controller->render(
            'index',
            [
                'searchForm' => $this->form,
                'dataProvider' => $dataProvider
            ]
        );
    }
}
