<?php

declare(strict_types = 1);

namespace frontend\models\user;

use Yii;

final class SignUpHandler
{
    private SignUpForm $signUpForm;

    public function __construct(SignUpForm $form)
    {
        $this->signUpForm = $form;
    }

    public function signUp(): bool
    {
        if (!$this->signUpForm->validate()) {

            return false;
        }

        $user = new Users(['attributes' => $this->signUpForm->attributes]);
        $user->password = Yii::$app->security->generatePasswordHash($this->signUpForm->password);

        return $user->save(false);
    }
}
