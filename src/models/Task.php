<?php
namespace htmlacademy\models;

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

    public function __construct($customerId, $executorId)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
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

    public function getAvailableActions($userId)
    {
        $actions = array_filter(self::MAP_AVAILABLE_ACTIONS[$this->status], function ($action) use ($userId) {
            return $action::isActionAvailable($userId, $this);
        });

        return $actions ?: null;
    }
}
