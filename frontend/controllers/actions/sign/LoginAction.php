<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use yii\web\Response;
use frontend\models\user\LoginForm;
use yii\widgets\ActiveForm;
use Yii;

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
    public function run()
    {
        $loginForm = Yii::$container->get(LoginForm::class);

        if ($loginForm->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
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
