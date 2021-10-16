<?php

declare(strict_types = 1);

use TaskForce\Controllers\{Task, CancelAction, ExecuteAction, AccomplishAction, FailAction};

require_once 'vendor/autoload.php';

$task = new Task(5, 4); //id заказчика = 5, id исполнителя = 4
echo 'текущий статус new <br><br>';

function myAssertHandler($file, $line, $code, $desc = null)
{
    echo "Неудачная проверка утверждения в $file, строка $line";

    if ($desc) {
        echo ": $desc <br>";
    }
    echo "<br>";
}
assert_options(ASSERT_CALLBACK, 'myAssertHandler');
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);



//проверка получения доступного действия при статусе 'new'
assert($task->getAvailableAction(5) instanceof CancelAction, 'Ожидаемое доступное действие в виде экземпляра CancelAction не получено');
assert($task->getAvailableAction(999, 'executant') instanceof ExecuteAction, 'Ожидаемое доступное действие в виде экземпляра ExecuteAction не получено');



//проверка получения доступного действия при статусе 'Отменено'
echo $task->setStatus(Task::STATUS_CANCELED);
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');



//проверка получения доступного действия при статусе 'В работе'
echo $task->setStatus(Task::STATUS_EXECUTING);
assert($task->getAvailableAction(5) instanceof AccomplishAction, 'Ожидаемое доступное действие в виде экземпляра AccomplishlAction не получено');
assert($task->getAvailableAction(4) instanceof FailAction, 'Ожидаемое доступное действие в виде экземпляра FailAction не получено');



//проверка получения доступного действия при статусе 'Провалено'
echo $task->setStatus(Task::STATUS_FAILED);
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');



//проверка получения доступного действия при статусе 'Выполнено'
echo $task->setStatus(Task::STATUS_ACCOMPLISHED);
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');
