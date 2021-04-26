<?php

declare(strict_types = 1);

namespace frontend\models\user;

use Yii;
use frontend\models\user\SignupForm;
use frontend\models\user\LoginForm;

final class SignHandler
{
    public function signup(SignupForm $form): bool
    {
        if (!$form->validate()) {

            return false;
        }

        $user = new Users(['attributes' => $form->attributes]);
        $user->password = Yii::$app->security->generatePasswordHash($form->password);

        return $user->save(false);
    }

    public function logout(): void
    {
        Yii::$app->user->logout();
    }

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
