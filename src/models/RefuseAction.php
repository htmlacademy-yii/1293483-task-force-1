<?php
namespace htmlacademy\models;

class RefuseAction extends AbstractAction
{
    public static function getTitle()
    {
        return 'Отказаться';
    }

    public static function getName()
    {
        return 'refuse';
    }

    public static function isActionAvailable($userId, Task $task)
    {
        return $userId === $task->executorId;
    }
}
