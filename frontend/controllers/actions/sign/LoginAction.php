<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\user\LoginForm;
use frontend\models\user\SignHandler;
use yii\web\{Request, Response};
use yii\widgets\ActiveForm;

class LoginAction extends BaseAction
{
    /** @var LoginForm $form */
    private LoginForm $form;

    public function __construct($id, $controller, LoginForm $form, SignHandler $handler)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $handler);
    }

    /**
     * Организовывает аутентификацию пользователя.
     *
     * Если тип запроса AJAX, отправляет ответ - результат валидации
     * формы входа в формате json. В случае успешной аутентификации
     * перенаправляет на домашнюю страницу, в ином случае - на главную.
     *
     * @return Response
     */
    public function run(Request $request): Response
    {
        if ($this->form->load($request->post())) {

            if ($request->isAjax) {
                return $this->controller
                    ->asJson(ActiveForm::validate($this->form));
            }

            if ($this->signHandler->login($this->form)) {
                return $this->controller->goHome();
            }
        }

        return $this->controller->redirect([self::ANON_PAGE_ROUTE]);
    }
}
