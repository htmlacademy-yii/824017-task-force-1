<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\{ResponseForm, Responses};
use frontend\models\reviews\ReviewForm;
use frontend\models\task\FailForm;
use frontend\models\user\Users;
use yii\web\{NotFoundHttpException, User, View};

class ViewAction extends BaseAction
{
    private const MODALS = [
        '_response_form' => ResponseForm::class,
        '_completion_form' => ReviewForm::class,
        '_fail_form' => FailForm::class,
        '_cancel_form' => ''
    ];

    /**
     * Отображает одно задание по его ID.
     *
     * Обращается к объекту свойства $service за получением объекта
     * задания, передовая аргументом ID задания.
     *
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException Если задание с переданным id не
     * было найдено.
     */
    public function run(int $id, View $view, User $user): string
    {
        $task = $this->service->getOneTask($id);

        if (!$task) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        $view->params['task_id'] = $id;
        $view->params['modals'] = '';

        foreach (self::MODALS as $name => $form) {
            $view->params['modals'] .= $this->controller->renderPartial(
                '@modalPath/' . $name,
                ['model' => class_exists($form) ? new $form() : $form]
            );
        }

        $user = $user->getIdentity();

        if ($task->customer_id === $user->id) {
            $responses = $task->responses;
        } elseif ($user->role === Users::ROLE_EXECUTANT) {
            $responses = Responses::findByUserAndTask($user->id, $task->id);
        } else {
            $responses = [];
        }

        $needShowChat = $user->id === $task->customer_id
            || $user->id === $task->executant_id;

        return $this->controller->render(
            'view',
            compact('task', 'responses', 'needShowChat')
        );
    }
}
