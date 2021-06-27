<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use yii\web\Response;

class LogoutAction extends BaseAction
{
    /**
     * Организовывает выход пользователя из системы
     * и перенаправляет на главную страницу.
     *
     * @return Response
     */
    public function run()
    {
        $this->signHandler->logout();

        return $this->controller->redirect([self::ANON_PAGE_ROUTE]);
    }
}
