<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\user\UserSearchForm;

class IndexAction extends BaseAction
{
    /**
     * Отображает всех исполнителей.
     *
     * Обращается к объекту свойства $service за получением массива
     * исполнителей, передовая аргументом модель формы поиска исполнителей.
     *
     * @return string
     */
    public function run(): string
    {
        $searchForm = $this->container->get(UserSearchForm::class);

        $users = $this->service->getUsers($searchForm);

        return $this->controller->render(
            'index',
            compact('users', 'searchForm')
        );
    }
}
