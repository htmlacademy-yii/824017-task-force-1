<?php

declare(strict_types = 1);

namespace frontend\controllers;

use frontend\models\user\{SignUpForm, SignHandler, LoginForm};
use yii\web\{Controller, Response};
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use Yii;

/**
 * SignController организовывает вход/выход пользователя,
 * регистрацию нового пользователя.
 */
class SignController extends Controller
{
    /** @var SignHandler $signHandler */
    private SignHandler $signHandler;

    /**
     * Выполняет инициализацию объекта.
     *
     * После инициализации создает объект SignHandler
     * и присваивает его одноименному свойству.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->signHandler = new SignHandler();
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
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function($rule, $action) {
                    if ($action->actionMethod === 'actionLogout') {

                       return $this->redirect(['landing/index']);
                    } else {

                        return $this->goHome();
                    }
                }
            ]
        ];
    }

    /**
     * Организовывает регистрацию пользователя.
     *
     * Если регистрация завершилась успешно,
     * перенаправляет на домашнюю страницу.
     *
     * @return Response|string
     */
    public function actionSignup()
    {
        $signupForm = new SignupForm;

        if ($signupForm->load(Yii::$app->request->post())) {

            if ($this->signHandler->signup($signupForm)) {

                return $this->goHome();
            }
        }

        return $this->render('index', ['model' => $signupForm]);
    }

    /**
     * Организовывает выход пользователя из системы
     * и перенаправляет на главную страницу.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->signHandler->logout();

        return $this->redirect(['landing/index']);
    }

    /**
     * Организовывает аутентификацию пользователя.
     *
     * Если тип запроса AJAX, отправляет ответ - результат валидации
     * формы входа в формате json. В случае успешной аутентификации
     * перенаправляет на домашнюю страницу, в ином случае - на главную.
     *
     * @return Response|array
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if ($loginForm->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($loginForm);
            }

            if ($this->signHandler->login($loginForm)) {

                return $this->goHome();
            }
        }

        return $this->redirect(['landing/index']);
    }
}
