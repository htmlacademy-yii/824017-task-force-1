<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use frontend\models\task\Tasks;

/**
 * Default controller for the `api` module
 */
class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function actionViewExecutantTasks()
    {
        $user_id = \Yii::$app->user->getId();

        return Tasks::findAll(['executant_id' => $user_id]);
    }

}
