<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\user\{UserService, UserSearchForm};
use yii\filters\AccessControl;

/**
 * UsersController выполняет действия по отображению
 * списка исполнителей или одного исполнителя.
 */
class UsersController extends Controller
{
    /** @var UserService $service */
    private UserService $service;

    /**
     * Выполняет инициализацию объекта.
     *
     * После инициализации создает объект UserService
     * и присваивает его свойству $service.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->service = new UserService($this->request);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Отображает всех исполнителей.
     *
     * Обращается к объекту свойства $service за получением массива
     * исполнителей, передовая аргументом модель формы поиска исполнителей.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchForm = new UserSearchForm();
        $users = $this->service->getUsers($searchForm);

        return $this->render('index', compact('users', 'searchForm'));
    }

    /**
     * Отображает одного исполнителя по его ID.
     *
     * Обращается к объекту свойства $service за получением объекта
     * исполнителя, передовая аргументом ID исполнителя.
     *
     * @param  string|null $id
     *
     * @return string
     */
    public function actionView(?string $id = null)
    {
        $user = $this->service->getOneUser($id);

        return $this->render('view', ['user' => $user]);
    }
}
