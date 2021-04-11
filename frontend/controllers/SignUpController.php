<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\SignUpForm;
use Yii;

class SignUpController extends Controller
{
    public function actionIndex()
    {
        $signUpForm = new SignUpForm;

        if ($signUpForm->load(Yii::$app->request->post())) {

            if ($signUpForm->validate()) {
                $newUser = $signUpForm;
                $newUser->password = Yii::$app->security->generatePasswordHash($newUser->password);
                $newUser->save(false);

                return $this->goHome();
            }
        }
        
        return $this->render('index', ['model' => $signUpForm]);
    }
}