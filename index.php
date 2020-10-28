<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
use htmlacademy\models\Task;

$customerId = 3;
$executorId = 5;
$task = new Task($customerId, $executorId);
$task->setStatus('new');

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

foreach ($task->getAvailableActions($customerId) as $action) {
    assert($action::getTitle() === 'Отменить', 'Задание в статусе «Новое» можно отменить, но сделать это может только автор задания');
}
foreach ($task->getAvailableActions($executorId) as $action) {
    assert($action::getTitle() === 'Откликнуться', 'На задание в статусе «Новое» может откликнуться только исполнитель');
}

$task->setStatus('canceled');
assert($task->getAvailableActions($customerId) === null, 'Задание в статусе «Отменено» не имеет доступных действий');

$task->setStatus('inWork');
foreach ($task->getAvailableActions($executorId) as $action) {
    assert($action::getTitle() === 'Отказаться', 'Задание в статусе «В работе» может отменить только исполнитель');
}
foreach ($task->getAvailableActions($customerId) as $action) {
    assert($action::getTitle() === 'Выполнено', 'Задание в статусе «В работе» может отметить выполненным только заказчик');
}

$task->setStatus('done');
assert($task->getAvailableActions($executorId) === null, 'Задание в статусе «Выполнено» не имеет доступных действий');

$task->setStatus('failed');
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
