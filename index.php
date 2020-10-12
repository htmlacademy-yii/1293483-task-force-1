<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
use htmlacademy\models\Task;

$task = new Task(3, 5);

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

$mapAvailableActions = [
    'new' => ['cancel', 'respond'],
    'canceled' => [],
    'inWork' => ['complete', 'refuse'],
    'done' => [],
    'failed' => [],
];

foreach ($mapAvailableActions as $status => $actions) {
    $taskActions = $task->getAvailableActions($status);

    foreach ($taskActions as $value) {
        assert(in_array($value, $actions), 'Недоступное действие ' . $value . ' для статуса ' . $status);
    }
}

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
