<?php
namespace htmlacademy\models;

class CompleteAction extends AbstractAction
{
    /**
     * Получение названия действия
     *
     * @return string
     */
    public static function getTitle(): string
    {
        return 'Выполнено';
    }

    /**
     * Получение внутреннего имени действия
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'complete';
    }

    /**
     * Проверка роли пользователя
     *
     * @param int $userId id пользователя
     * @param Task $task Экземпляр задания
     *
     * @return bool
     */
    public static function isActionAvailable(int $userId, Task $task): bool
    {
        return $userId === $task->customerId;
    }
}
