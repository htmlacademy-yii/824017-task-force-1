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

// проверка метода для возврата «карты» статусов и действий
assert($task->getMappingElementValue(Task::TO_FAIL) === 'Отказаться', 'Ожидаемое название действия на русском не получено');
assert($task->getMappingElementValue(Task::STATUS_CANCELED) === 'Отменено', 'Ожидаемое название статуса на русском не получено');



/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'new'  */
//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert($task->getStatusCausedByAction(Task::TO_CANCEL) === Task::STATUS_CANCELED, 'Ожидаемый статус canceled не получен');
assert($task->getStatusCausedByAction(Task::TO_EXECUTE) === Task::STATUS_EXECUTING, 'Ожидаемый статус executing не получен');

//проверка получения доступного
assert($task->getAvailableAction(5) instanceof CancelAction, 'Ожидаемое доступное действие в виде экземпляра CancelAction не получено');
assert($task->getAvailableAction(999, 'executant') instanceof ExecuteAction, 'Ожидаемое доступное действие в виде экземпляра ExecuteAction не получено');



/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Отменено'  */
echo $task->setStatus(Task::STATUS_CANCELED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction(Task::TO_CANCEL)), 'Ожидаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction(Task::TO_ACCOMPLISH)), 'Ожидаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');




/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'В работе'  */
echo $task->setStatus(Task::STATUS_EXECUTING);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert($task->getStatusCausedByAction(Task::TO_ACCOMPLISH) === Task::STATUS_ACCOMPLISHED, 'Ожидаемый статус accomplished не получен');
assert($task->getStatusCausedByAction(Task::TO_FAIL) === Task::STATUS_FAILED, 'Ожидаемый статус failed не получен');

//проверка получения доступного действия
assert($task->getAvailableAction(5, 'customer') instanceof AccomplishAction, 'Ожидаемое доступное действие в виде экземпляра AccomplishlAction не получено');
assert($task->getAvailableAction(4, 'executant') instanceof FailAction, 'Ожидаемое доступное действие в виде экземпляра FailAction не получено');



/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Провалено'  */
echo $task->setStatus(Task::STATUS_FAILED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction(Task::TO_EXECUTE)), 'Ожидаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction(Task::TO_FAIL)), 'Ожидаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');



/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Выполнено'  */
echo $task->setStatus(Task::STATUS_ACCOMPLISHED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction('to eat ice-cream')), 'Ожидаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction('to fly to the Moon')), 'Ожидаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(5)), 'Ожидаемое значение null не получено');
assert(is_null($task->getAvailableAction(4)), 'Ожидаемое значение null не получено');
