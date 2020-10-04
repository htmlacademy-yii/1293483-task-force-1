<?php
namespace htmlacademy;

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
        self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
        self::STATUS_IN_WORK => [self::ACTION_COMPLETE, self::ACTION_REFUSE],
    ];

    private $executorId;
    private $customerId;
    private $status;

    public function __construct($executorId, $customerId)
    {
        $this->status = self::STATUS_NEW;
        $this->executorId = $executorId;
        $this->customerId = $customerId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMapActions()
    {
        return self::MAP_ACTIONS;
    }

    public function getMapStatuses()
    {
        return self::MAP_STATUSES;
    }

    public function getStatusByAction($action)
    {
        return self::MAP_STATUS_BY_ACTION[$action];
    }

    public function getAvailableActions($status)
    {
        return self::MAP_AVAILABLE_ACTIONS[$status];
    }
}
