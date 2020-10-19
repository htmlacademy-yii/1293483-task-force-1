<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
use htmlacademy\models\Task;

$customerId = 3;
$executorId = 5;
$task = new Task($customerId, $executorId);

assert($task->getStatus() === 'new');

$mapStatusByAction = [
    'cancel' => 'canceled',
    'respond' => 'inWork',
    'complete' => 'done',
    'refuse' => 'failed',
];

foreach ($mapStatusByAction as $action => $status) {
    assert($task->getStatusByAction($action) === $status, 'Неправильный статус ' . $status . ' для действия ' . $action);
}

assert($task->getAvailableActions('new', $customerId)->getTitle() === 'Отменить', 'Задание в статусе «Новое» можно отменить, но сделать это может только автор задания');
assert($task->getAvailableActions('new', $executorId)->getTitle() === 'Откликнуться', 'На задание в статусе «Новое» может откликнуться только исполнитель');
assert($task->getAvailableActions('canceled', $customerId) === null, 'Задание в статусе «Отменено» не имеет доступных действий');
assert($task->getAvailableActions('inWork', $executorId)->getTitle() === 'Отказаться', 'Задание в статусе «В работе» может отменить только исполнитель');
assert($task->getAvailableActions('inWork', $customerId)->getTitle() === 'Выполнено', 'Задание в статусе «В работе» может отметить выполненным только заказчик');
assert($task->getAvailableActions('done', $executorId) === null, 'Задание в статусе «Выполнено» не имеет доступных действий');
assert($task->getAvailableActions('failed', $executorId) === null, 'Задание в статусе «Провалено» не имеет доступных действий');

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
