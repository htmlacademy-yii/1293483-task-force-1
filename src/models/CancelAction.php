<?php
namespace htmlacademy\models;

class CancelAction extends AbstractAction
{
    public static function getTitle()
    {
        return 'Отменить';
    }

    public static function getName()
    {
        return 'cancel';
    }

    public static function isActionAvailable($userId, Task $task)
    {
        return $userId === $task->customerId;
    }
}
