<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task\TaskSearchForm;

class IndexAction extends BaseAction
{
    /**
     * Организовывает просмотр новых заданий.
     *
     * Обращается к объекту свойства $service за получением провайдера данных,
     * передовая аргументом модель формы поиска заданий.
     *
     * @return string
     */
    public function run()
    {
        $searchForm = \Yii::$container->get(TaskSearchForm::class);

        $dataProvider = $this->service->getDataProvider($searchForm);

        return $this->controller
            ->render('index', compact('searchForm', 'dataProvider'));
    }
}
