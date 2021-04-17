<?php

declare(strict_types = 1);

namespace frontend\models\user;

use yii\web\Request;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

class UserService extends BaseObject
{
    private Request $request;

    public function __construct(Request $request, array $config = [])
    {
        parent::__construct($config);
        $this->request = $request;
    }

    public function getUsers(UserSearchForm $form): ?array
    {
        $this->request->isGet ? $this->getFiltering($form) : $this->postFiltering($form);

        if (array_filter($form->attributes)) {
            return Users::findExecutantsByFilters($form);
        }

        return Users::findExecutants();
    }

    public function getOneUser(?string $id = null): Users
    {
        $user = Users::findOne($id);
        if (!$user || $user->role !== 'executant') {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $user;
    }

    private function getFiltering(UserSearchForm $form)
    {
        $id = $this->request->get('specialization_id');

        if (key_exists($id, $form->getSpecializations())) {
            $form->searchedSpecializations[$id] = $id;
        }
    }

    private function postFiltering(UserSearchForm $form)
    {
        $form->load($this->request->post());
    }
}
