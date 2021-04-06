<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\Users;
use yii\helpers\ArrayHelper;
use frontend\models\cities\Cities;
use Yii;

class SignUpController extends Controller
{
    public function actionIndex()
    {
        $cities = ArrayHelper::map(Cities::find()->asArray()->all(), 'id', 'name');
        $user = new Users;
        
        if (Yii::$app->request->getIsPost()) {
            $user->load(Yii::$app->request->post());

            if ($user->validate()) {
                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                $user->save(false);
                $this->goHome();
            }
        }

        return $this->render('index', ['model' => $user, 'cities' => $cities]);
    }
}