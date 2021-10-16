<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\user\{UserSearchForm, UserService};

class IndexAction extends BaseAction
{
    /** @var UserSearchForm $form */
    private UserSearchForm $form;

    public function __construct(
        $id,
        $controller,
        UserSearchForm $form,
        UserService $service
    ) {
        $this->form = $form;
        parent::__construct($id, $controller, $service);
    }

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
        $users = $this->service->getUsers($this->form);

        return $this->controller->render(
            'index',
            [
                'users' => $users,
                'searchForm' => $this->form
            ]
        );
    }
}
