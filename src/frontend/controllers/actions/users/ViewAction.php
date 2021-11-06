<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use yii\web\NotFoundHttpException;

class ViewAction extends BaseAction
{
    /**
     * Отображает одного исполнителя по его ID.
     *
     * Обращается к объекту свойства $service за получением объекта
     * исполнителя, передовая аргументом ID исполнителя.
     *
     * @param  int $id
     *
     * @throws NotFoundHttpException Если исполнитель с переданным id не
     * был найден.
     *
     * @return string
     */
    public function run(int $id): string
    {
        $user = $this->service->getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->controller->render('view', ['user' => $user]);
    }
}
