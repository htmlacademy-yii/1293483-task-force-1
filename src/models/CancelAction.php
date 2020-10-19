<?php
namespace htmlacademy\models;

class CancelAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Отменить';
    }

    public function getName()
    {
        return 'cancel';
    }

    public  function isActionAvailable($userId, $customerId, $executorId)
    {
        return $userId === $customerId ? true : false;
    }
}
