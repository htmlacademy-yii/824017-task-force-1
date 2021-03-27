<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\task\{TaskService, TaskSearchForm, TaskCreatingForm};
use yii\filters\AccessControl;
use TaskForce\Utils\Uploader;
use Yii;

/**
 * TasksController организовывает просмотр заданий и добавление нового задания.
 */
class TasksController extends Controller
{
    /** @var TasksService $service */
    private TaskService $service;

    /**
     * Выполняет инициализацию объекта.
     *
     * После инициализации создает объект TaskService
     * и присваивает его свойству $service.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->service = new TaskService($this->request);
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
                        'actions' => ['add', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->getIdentity()->role === 'customer';
                        }
                    ],
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
     * Организовывает просмотр новых заданий.
     *
     * Обращается к объекту свойства $service за получением провайдера данных,
     * передовая аргументом модель формы поиска заданий.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchForm = new TaskSearchForm();
        $dataProvider = $this->service->getDataProvider($searchForm);

        return $this->render('index', compact('dataProvider', 'searchForm'));
    }

    /**
     * Отображает одно задание по его ID.
     *
     * Обращается к объекту свойства $service за получением объекта
     * задания, передовая аргументом ID задания.
     *
     * @param  string|null $id
     *
     * @return string
     */
    public function actionView(?string $id = null)
    {
        $task = $this->service->getOneTask($id);

        return $this->render('view', ['task' => $task]);
    }

    /**
     * Сохраненяет файл задания на сервере при помощи Uploader'а.
     *
     * @return void
     */
    public function actionUploadFile()
    {
        Uploader::uploadFile();
    }

    /**
     * Организовывает добавление нового задания.
     *
     * При помощи объекта сервиса добавляет новое задание, передавая аргументом
     * форму добавления задания. Если успешно, перенаправляет на домашнюю
     * страницу. В ином случае отображает форму с ошибками.
     *
     * @return Response|string
     */
    public function actionAdd()
    {
        $taskCreatingForm = new TaskCreatingForm;

        if ($this->service->add($taskCreatingForm)) {

            return $this->goHome();
        }

        return $this->render('add', ['taskCreatingForm' => $taskCreatingForm]);
    }

    /**
     * Определяет имя класса для действия error.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'upload', 'add'],
                'rules' => [
                    [
                        'actions' => ['add', 'upload'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return $this->user->role === 'customer';
                        }
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }
}
