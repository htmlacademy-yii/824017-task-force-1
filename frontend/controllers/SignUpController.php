<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\Users;
use yii\helpers\ArrayHelper;
use frontend\models\cities\Cities;
use frontend\models\user\SignUpForm;
use Yii;

class SignUpController extends Controller
{
    public function actionIndex()
    {
        $signUpForm = new SignUpForm;



        if ($signUpForm->load(Yii::$app->request->post())) {
            //var_dump($signUpForm->attributes);
            if ($signUpForm->validate()) {
                $signUpForm->password = Yii::$app->security->generatePasswordHash($signUpForm->password);
                $newUser = new Users(['attributes' => $signUpForm->attributes]);
                
                var_dump($newUser->attributes);
                

                $newUser->save(false);
                $this->goHome();
            }
        }
        

        return $this->render('index', ['model' => $signUpForm]);
    }
}