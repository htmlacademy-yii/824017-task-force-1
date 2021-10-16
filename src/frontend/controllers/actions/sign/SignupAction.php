<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\user\SignHandler;
use frontend\models\user\SignUpForm;
use yii\web\{Request, Response};

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
    public function run(Request $request): Response|string //это же не нарушает критерий Д18? то есть, ну методу run то
    {                                                      // можно разные типы возвращать..наверное. не разбивать же run на два метода.
        if ($this->form->load($request->post())) {         // 1 - для случая отображения инф, 2 - для случая возврата объекта response.
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
