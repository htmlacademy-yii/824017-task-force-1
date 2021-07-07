<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use yii\web\{Response, Request};
use frontend\models\user\SignUpForm;

class SignupAction extends BaseAction
{
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
        $model = $this->container->get(SignupForm::class);

        if ($model->load($request->post())) {

            if ($this->signHandler->signup($model)) {

                return $this->controller->goHome();
            }
        }

        return $this->controller->render(
            'index',
            compact('model')
        );
    }
}
