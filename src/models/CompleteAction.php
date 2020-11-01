<?php
namespace htmlacademy\models;

class CompleteAction extends AbstractAction
{
    public static function getTitle()
    {
        return 'Выполнено';
    }

    public static function getName()
    {
        return 'complete';
    }

    public static function isActionAvailable($userId, Task $task)
    {
        return $userId === $task->customerId;
    }
}
