<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use frontend\models\chatMessages\ChatMessages;
use yii\web\ServerErrorHttpException;
use yii\helpers\Url;
use Yii;

/**
 * Default controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = ChatMessages::class;

    public function actionViewTaskMessages()
    {
        $taskId = Yii::$app->request->get('task_id');
        $userId = Yii::$app->user->getId();
        $messages = ChatMessages::find()->where(['task_id' => $taskId])->orderBy('date_time ASC')->all();

        foreach ($messages ?? [] as $message) {
            $message->is_mine = $userId === $message->user_id;
        }

        return $messages;
    }

    public function actionAddMessage()
    {
        $user_id = Yii::$app->user->getId();
        $newMessage = new $this->modelClass();
        $newMessage->load(Yii::$app->getRequest()->getBodyParams(), '');
        $newMessage->user_id = $user_id;
        
        if ($newMessage->save(false)) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = $newMessage->getPrimaryKey();
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$newMessage->hasErrors()) {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }

        return $newMessage;
    }
}
