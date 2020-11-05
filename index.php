<?php
declare(strict_types = 1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use htmlacademy\exceptions\IncorrectDataException;
use htmlacademy\models\Task;

$customerId = 3;
$executorId = 5;
$task = new Task($customerId, $executorId);
try {
    $task->setStatus('new');
} catch (IncorrectDataException $e) {
    error_log("Не удалось установить статус: " . $e->getMessage());
}

assert($task->getStatus() === 'new');

$mapStatusByAction = [
    'cancel' => 'canceled',
    'respond' => 'inWork',
    'complete' => 'done',
    'refuse' => 'failed',
];

foreach ($mapStatusByAction as $action => $status) {
    try {
        $taskStatus = $task->getStatusByAction($action);
    } catch (IncorrectDataException $e) {
        error_log("Не удалось получить статус: " . $e->getMessage());
    }
    assert($taskStatus === $status, 'Неправильный статус ' . $status . ' для действия ' . $action);
}

foreach ($task->getAvailableActions($customerId) as $action) {
    assert($action::getTitle() === 'Отменить', 'Задание в статусе «Новое» можно отменить, но сделать это может только автор задания');
}
foreach ($task->getAvailableActions($executorId) as $action) {
    assert($action::getTitle() === 'Откликнуться', 'На задание в статусе «Новое» может откликнуться только исполнитель');
}

try {
    $task->setStatus('canceled');
} catch (IncorrectDataException $e) {
    error_log("Не удалось установить статус: " . $e->getMessage());
}
assert($task->getAvailableActions($customerId) === null, 'Задание в статусе «Отменено» не имеет доступных действий');

try {
    $task->setStatus('inWork');
} catch (IncorrectDataException $e) {
    error_log("Не удалось установить статус: " . $e->getMessage());
}
foreach ($task->getAvailableActions($executorId) as $action) {
    assert($action::getTitle() === 'Отказаться', 'Задание в статусе «В работе» может отменить только исполнитель');
}
foreach ($task->getAvailableActions($customerId) as $action) {
    assert($action::getTitle() === 'Выполнено', 'Задание в статусе «В работе» может отметить выполненным только заказчик');
}

try {
    $task->setStatus('done');
} catch (IncorrectDataException $e) {
    error_log("Не удалось установить статус: " . $e->getMessage());
}
assert($task->getAvailableActions($executorId) === null, 'Задание в статусе «Выполнено» не имеет доступных действий');

try {
    $task->setStatus('failed');
} catch (IncorrectDataException $e) {
    error_log("Не удалось установить статус: " . $e->getMessage());
}
assert($task->getAvailableActions($executorId) === null, 'Задание в статусе «Провалено» не имеет доступных действий');

$mapStatuses = [
    'new' => 'Новое',
    'canceled' => 'Отменено',
    'inWork' => 'В работе',
    'done' => 'Выполнено',
    'failed' => 'Провалено',
];

assert($task->getMapStatuses() === $mapStatuses, 'Карта статусов не совпадает');

$mapActions = [
    'cancel' => 'Отменить',
    'respond' => 'Откликнуться',
    'complete' => 'Выполнено',
    'refuse' => 'Отказаться',
];

assert($task->getMapActions() === $mapActions, 'Карта действий не совпадает');
