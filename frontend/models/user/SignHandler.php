<?php

declare(strict_types = 1);

namespace frontend\models\user;

use frontend\models\user\{SignupForm, LoginForm};
use Yii;

/**
 * SignHandler непосредственно осуществляет вход/выход пользователя и
 * регистрацию нового пользователя.
 */
final class SignHandler
{
    /**
     * Регистрирует нового пользователя.
     *
     * Валидирует форму регистрации. Если успешно, создает
     * и сохраняет в базе данных нового пользователя.
     *
     * @param SignupForm $form Модель формы регистрации.
     *
     * @return bool Завершилась ли регистрация успешно.
     */
    public function signup(SignupForm $form): bool
    {
        if (!$form->validate()) {

            return false;
        }

        $user = new Users(['attributes' => $form->attributes]);
        $user->password = Yii::$app->security
            ->generatePasswordHash($form->password);

        return $user->save(false);
    }

    /**
     * Выполняет выход из системы.
     *
     * @return void
     */
    public function logout(): void
    {
        Yii::$app->user->logout();
    }

    /**
     * Логинит пользователя.
     *
     * Валидирует форму входа. Если валидация успешна, логинит пользователя и
     * возвращает true. В ином случае вернет false.
     *
     * @param LoginForm $form Модель формы входа.
     *
     * @return bool
     */
    public function login(LoginForm $form): bool
    {
        if ($form->validate()) {
            $user = $form->user;
            Yii::$app->user->login($user);

            return true;
        }

        return false;
    }
}
