<?php

declare(strict_types = 1);

namespace frontend\models\task;

use yii\web\Request;
use yii\base\{BaseObject, Model};
use yii\data\ActiveDataProvider;
use TaskForce\Controllers\Task;
use frontend\models\task\TaskCreatingForm;
use frontend\models\responses\ResponseForm;
use frontend\models\responses\Responses;
use frontend\models\reviews\ReviewForm;
use frontend\models\reviews\Reviews;
use frontend\models\FailForm;
use frontend\models\task\Tasks;
use frontend\models\user\Users;

/**
 * TaskService предоставляет информацию об заданиях, сохраняет новое задание.
 */
class TaskService extends BaseObject
{
    /** @var Request $request */
    private Request $request;

    /**
     * Создает экземпляр класса и присваивает свойству $request объекта запроса.
     *
     * @param Request $request
     */
    public function __construct(Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }

    /**
     * Возвращает провайдер данных.
     *
     * Определяет тип запроса и зависимости от него загружает модель
     * TaskSearchForm данными из $_GET или $_POST. Если в форме поиска не было
     * заполнено ни одно поле, то передаст в провайдер данных запрос всех новых
     * заданий. В ином случае - запрос в соответствии с формой поиска.
     *
     * @param TaskSearchForm $form Модель формы поиска заданий.
     *
     * @return ActiveDataProvider
     */
    public function getDataProvider(TaskSearchForm $form): ActiveDataProvider
    {
        $this->request->isGet ? $this->loadFromGet($form) : $this->loadFromPost($form);

        if (array_filter($form->attributes)) {
            $query = Tasks::findNewTasksByFilters($form);
        } else {
            $query = Tasks::findNewTasks();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $dataProvider;
    }

    /**
     * Находит одно задание по первичному ключу.
     *
     * @param  int $id Id задания.
     *
     * @return Tasks|null Объект задания, если найден, иначе null.
     */
    public function getOneTask(int $id): ?Tasks
    {
        $task = Tasks::findOne($id);

        return $task;
    }

    /**
     * Валидирует форму добавления задания и сохраняет информацию
     * о задании в БД.
     *
     * Загружает форму данными из $_POST. Если успешно, то валидирует форму.
     * Если последнее тоже успешно, то сохраняет в таблице заданий новое
     * задание, а в таблице файлов пути к файлам этого задания, записанные ранее
     * в сессию действием upload-file контроллера tasks.
     *
     * @param TaskCreatingForm $form Модель формы добавления задания.
     *
     * @return bool Завершился ли процесс добавления задания успешно.
     */
    public function add(TaskCreatingForm $taskCreatingForm): bool
    {
        if ($this->loadFromPost($taskCreatingForm)) {

            if ($taskCreatingForm->validate()) {
                $newTask = new Tasks([
                    'attributes' => $taskCreatingForm->attributes
                ]);
                $newTask->customer_id = \Yii::$app->user->id;
                $newTask->status = Task::STATUS_NEW;
                $newTask->save(false);

                $session = \Yii::$app->session;

                foreach ($session['paths'] ?? [] as $path) {
                    $newTaskHelpfulFile = new TaskHelpfulFiles([
                        'helpful_file' => $path,
                        'task_id' => $newTask->id
                    ]);
                    $newTaskHelpfulFile->save(false);
                }

                return true;
            }
        }

        return false;
    }

    public function addResponse(ResponseForm $form): void //одноименный метод. как у контроллера... 
    {
        $this->loadFromPost($form);
        $form->user_id = \Yii::$app->user->id;

        if ($form->validate()) {
            $newResponse = new Responses(['attributes' => $form->attributes]);
            $newResponse->save();
        }
    }

    public function accomplish(ReviewForm $form): void
    {
        $this->loadFromPost($form);

        if ($form->validate()) {
            $task = Tasks::findOne($form->task_id);
            $task->status = $form->completion === '1' ? Task::STATUS_ACCOMPLISHED : Task::STATUS_FAILED;
            $task->save();

            $newReview = new Reviews(['attributes' => $form->attributes]);
            $newReview->executant_id = $task->executant_id;
            $newReview->customer_id = $task->customer_id;
            $newReview->save();
        }
    }

    public function fail(FailForm $form): void
    {
        $this->loadFromPost($form);
        $task = Tasks::findOne($form->task_id);
        $task->status = Task::STATUS_FAILED;
        $task->save();//стоит ли добавить пустую строку, как в методе выше?
        $executant = Users::findOne($task->executant_id);
        $executant->failure_count++;
        $executant->save();
    }

    public function cancel(string $task_id): void
    {
        $task = Tasks::findOne($task_id);
        $taskHelper = new Task($task->customer_id, $task->executant_id, $task->status);
        $task->status = $taskHelper->getStatusCausedByAction(Task::TO_CANCEL);
        $task->save();
    }

    /**
     * Добавляет в форму поиска id специализации искомых заданий.
     *
     * Если в GET запросе есть параметр запроса - id специализации, и,
     * если такая специализация существует в таблице специализаций, то
     * добавит этот id в массив свойства searchedSpecializations под ключом
     * этого же id.
     *
     * @param TaskSearchForm $form Модель формы поиска заданий.
     *
     * @return void
     */
    private function loadFromGet(TaskSearchForm $form): void
    {
        $id = $this->request->get('specialization_id');

        if (key_exists($id, $form->getSpecializations())) {
            $form->searchedSpecializations[$id] = $id;
        }
    }

    /**
     * Загружает модель данными из $_POST.
     *
     * Загружает модель данными из массива $_POST при помощи объекта запроса
     * $this->request.
     *
     * @param Model $form Загружаемая модель.
     *
     * @return bool Были ли найдены данные для загрузки модели в $_POST.
     */
    private function loadFromPost(Model $form): bool
    {
        return $form->load($this->request->post());
    }
}
