<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\SearchUserForm;
use frontend\models\Users;
use yii\helpers\ArrayHelper;
use frontend\models\Cities;
use Yii;

class SignUpController extends Controller
{
    public function actionIndex()
    {
        //var_dump(',,,,,,,,,');
        $cities = ArrayHelper::map(Cities::find()->asArray()->all(), 'id', 'name');
        //var_dump('УРААА');

        $user = new Users;

        
        if (Yii::$app->request->getIsPost()) {
            //var_dump('ДАА это ПОСТ');
            $user->load(Yii::$app->request->post());

            if ($user->validate()) {

                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                $user->save(false);
                
                /*$this->goHome();*/
            }
        }

        return $this->render('sign-up', ['model' => $user, 'cities' => $cities]);
    } 
}