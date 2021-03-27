<?php

declare(strict_types = 1);

namespace frontend\models;

use frontend\models\UserSearchForm;
use yii\web\Request;
use yii\base\BaseObject;

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
        switch ($this->request->method) {
            case 'GET':
                $id = $this->request->get('specialization_id');

                if (key_exists($id, $form->getSpecializations())) {
                    $form->searchedSpecializations[$id] = $id;
                }

                break;

            case 'POST':
                if ($this->request->post('UserSearchForm')['searchedName']) {
                    $form->searchedName = $this->request->post('UserSearchForm')['searchedName'];
                } else {
                    $form->load($this->request->post());
                } 

                break;
        }

        if (array_filter($form->attributes)) {
            return Users::findExecutantsByFilters($form);
        }

        return Users::findExecutants();
    }
}