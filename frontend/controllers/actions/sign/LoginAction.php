<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use yii\web\{Response, Request};
use frontend\models\user\LoginForm;
use yii\widgets\ActiveForm;

class LoginAction extends BaseAction
{
    /**
     * Организовывает аутентификацию пользователя.
     *
     * Если тип запроса AJAX, отправляет ответ - результат валидации
     * формы входа в формате json. В случае успешной аутентификации
     * перенаправляет на домашнюю страницу, в ином случае - на главную.
     *
     * @return Response|array
     */
    public function run(Request $request)
    {
        $loginForm = $this->container->get(LoginForm::class);

        if ($loginForm->load($request->post())) {

            if ($request->isAjax) {
                return $this->controller
                    ->asJson(ActiveForm::validate($loginForm));
            }

            if ($this->signHandler->login($loginForm)) {
                return $this->controller->goHome();
            }
        }

        return $this->controller->redirect([self::ANON_PAGE_ROUTE]);
    }
}
