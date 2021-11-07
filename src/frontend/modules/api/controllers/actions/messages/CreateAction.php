<?php

declare(strict_types=1);

namespace frontend\modules\api\controllers\actions\messages;

use frontend\models\ChatMessages;
use yii\rest\Action;
use yii\web\{Request, Response, ServerErrorHttpException, User};

/**
 * Отправляет сообщение в чат.
 */
class CreateAction extends Action
{
    /**
     * @return array
     */
    public function run(User $user, Request $request, Response $response): array
    {
        /** @var ChatMessages $newMessage */
        $newMessage = new $this->modelClass();
        $newMessage->load($request->getBodyParams(), '');
        $newMessage->user_id = $user->getId();
        $newMessage->date_time = strftime('%F %T');

        if (!$newMessage->save(false)) {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }

        $response->setStatusCode(201);
        $newMessageData = $newMessage->getAttributes();
        $newMessageData['is_mine'] = true;

        return $newMessageData;
    }
}
