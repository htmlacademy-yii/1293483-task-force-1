<?php
namespace htmlacademy\models;

class CancelAction extends AbstractAction
{
    /**
     * Получение названия действия
     *
     * @return string
     */
    public static function getTitle(): string
    {
        return 'Отменить';
    }

    /**
     * Получение внутреннего имени действия
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'cancel';
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
