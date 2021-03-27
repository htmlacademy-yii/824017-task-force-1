<?php

declare(strict_types = 1);

namespace frontend\models\user;

use yii\web\{Request, NotFoundHttpException};
use yii\base\BaseObject;

/**
 * UserService предоставляет информацию об исполнителях,
 * используя объект запроса.
 */
class UserService extends BaseObject
{
    /** @var Request $request */
    private Request $request;

    /**
     * Создает экземпляр класса и присваивает свойству $request объекта запроса.
     *
     * @param Request $request
     * @param array $config
     */
    public function __construct(Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }

    /**
     * Возвращает массив исполнителей.
     *
     * Определяет тип запроса и зависимости от него загружает модель
     * UserSearchForm данными из $_GET или $_POST. Если в форме поиска
     * не было заполнено ни одно поле, то вернет непосредственно всех
     * исполнителей. В ином случае - в соответствии с формой поиска.
     *
     * @param UserSearchForm $form Модель формы поиска исполнителей.
     *
     * @return array|null Массив исполнителей, если они были найдены,
     * null в ином случае.
     */
    public function getUsers(UserSearchForm $form): ?array
    {
        $this->request->isGet ? $this->loadFromGet($form) : $this->loadFromPost($form);

        if (array_filter($form->attributes)) {
            return Users::findExecutantsByFilters($form);
        }

        return Users::findExecutants();
    }

    /**
     * Находит одного исполнителя по первичному ключу.
     *
     * @param string|null $id Id исполнителя.
     *
     * @throws NotFoundHttpException Если исполнитель с переданным id не
     * был найдено, или если параметр запроса не был передан.
     *
     * @return Users Объект исполнителя.
     */
    public function getOneUser(?string $id = null): Users
    {
        $user = Users::findOne($id);
        if (!$user || $user->role !== 'executant') {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $user;
    }

    /**
     * Добавляет в форму поиска id специализации искомых исполнителей.
     *
     * Если в GET запросе есть параметр запроса - id специализации, и,
     * если такая специализация существует в таблице специализаций, то
     * добавит этот id в массив свойства searchedSpecializations под ключом
     * этого же id.
     *
     * @param UserSearchForm $form Модель формы поиска исполнителей.
     *
     * @return void
     */
    private function loadFromGet(UserSearchForm $form)
    {
        $id = $this->request->get('specialization_id');

        if (key_exists($id, $form->getSpecializations())) {
            $form->searchedSpecializations[$id] = $id;
        }
    }

    /**
     * Загружает модель формы поиска исполнителей данными из $_POST.
     *
     * Загружает модель данными из массива $_POST при помощи объекта запроса
     * $this->request.
     *
     * @param UserSearchForm $form Загружаемая модель.
     *
     * @return bool Были ли найдены данные для загрузки модели в $_POST.
     */
    private function loadFromPost(UserSearchForm $form)
    {
        $form->load($this->request->post());
    }
}
