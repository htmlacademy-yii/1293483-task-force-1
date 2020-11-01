<?php
namespace htmlacademy\models;

class RespondAction extends AbstractAction
{
    public static function getTitle()
    {
        return 'Откликнуться';
    }

    public static function getName()
    {
        return 'respond';
    }

    public static function isActionAvailable($userId, Task $task)
    {
        return $userId === $task->executorId;
    }
}
