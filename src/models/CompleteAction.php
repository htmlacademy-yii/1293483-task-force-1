<?php
namespace htmlacademy\models;

class CompleteAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Выполнено';
    }

    public function getName()
    {
        return 'complete';
    }

    public  function isActionAvailable($userId, $customerId, $executorId)
    {
        return $userId === $customerId ? true : false;
    }
}
