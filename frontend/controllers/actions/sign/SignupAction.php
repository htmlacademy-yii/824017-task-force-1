<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\user\SignHandler;
use yii\web\{Response, Request};
use frontend\models\user\SignUpForm;

class SignupAction extends BaseAction
{
    /** @var SignupForm $form */
    private SignupForm $form;

    public function __construct($id, $controller, SignupForm $form, SignHandler $handler)
    {
        $this->form = $form;
        parent::__construct($id, $controller, $handler);
    }

    /**
     * Организовывает регистрацию пользователя.
     *
     * Если регистрация завершилась успешно,
     * перенаправляет на домашнюю страницу.
     *
     * @return Response|string
     */
    public function run(Request $request)
    {
        if ($this->form->load($request->post())) {

            if ($this->signHandler->signup($this->form)) {

                return $this->controller->goHome();
            }
        }

        return $this->controller->render(
            'index',
            ['model' => $this->form]
        );
    }
}
