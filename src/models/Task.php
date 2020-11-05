<?php
declare(strict_types = 1);

namespace htmlacademy\models;

use htmlacademy\exceptions\IncorrectDataException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'inWork';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_COMPLETE = 'complete';
    const ACTION_REFUSE = 'refuse';

    const MAP_STATUSES = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAILED => 'Провалено'
    ];
    const MAP_ACTIONS = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_COMPLETE => 'Выполнено',
        self::ACTION_REFUSE => 'Отказаться',
    ];

    const MAP_STATUS_BY_ACTION = [
        self::ACTION_CANCEL => self::STATUS_CANCELED,
        self::ACTION_RESPOND => self::STATUS_IN_WORK,
        self::ACTION_COMPLETE => self::STATUS_DONE,
        self::ACTION_REFUSE => self::STATUS_FAILED
    ];
    const MAP_AVAILABLE_ACTIONS = [
        self::STATUS_NEW => [CancelAction::class, RespondAction::class],
        self::STATUS_CANCELED => [],
        self::STATUS_IN_WORK => [CompleteAction::class, RefuseAction::class],
        self::STATUS_DONE => [],
        self::STATUS_FAILED => [],
    ];

    public $executorId;
    public $customerId;
    public $status;

    /**
     * Конструктор
     *
     * @param int $customerId id заказчика
     * @param int $executorId id исполнителя
     */
    public function __construct(int $customerId, int $executorId)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    /**
     * Получение статуса задачи
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Установка статуса задания
     *
     * @param string $status Статус
     *
     * @throws
     * @return void
     */
    public function setStatus(string $status): void
    {
        if (!isset(self::MAP_STATUSES[$status])) {
            throw new IncorrectDataException('Указанный статус не существует: ' . $status);
        }

        $this->status = $status;
    }

    /**
     * Получение карты действий
     *
     * @return array
     */
    public function getMapActions(): array
    {
        return self::MAP_ACTIONS;
    }

    /**
     * Получение карты статусов
     *
     * @return array
     */
    public function getMapStatuses(): array
    {
        return self::MAP_STATUSES;
    }

    /**
     * Получение имя статуса, в который перейдёт задание после выполнения действия
     *
     * @param string $action Действие
     *
     * @throws
     * @return string
     */
    public function getStatusByAction(string $action): string
    {
        if (!isset(self::MAP_ACTIONS[$action])) {
            throw new IncorrectDataException('Указанное действие не существует: ' . $action);
        }

        return self::MAP_STATUS_BY_ACTION[$action];
    }

    /**
     * Получение доступного действия исходя из статуса задания и роли пользователя
     *
     * @param int $userId id пользователя
     *
     * @return array | null
     */
    public function getAvailableActions(int $userId): ?array
    {
        $actions = array_filter(self::MAP_AVAILABLE_ACTIONS[$this->status], function ($action) use ($userId) {
            return $action::isActionAvailable($userId, $this);
        });

        return $actions ?: null;
    }
}
