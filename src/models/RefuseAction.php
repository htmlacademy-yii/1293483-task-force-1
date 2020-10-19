<?php
namespace htmlacademy\models;

class RefuseAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Отказаться';
    }

    public function getName()
    {
        return 'refuse';
    }

    public  function isActionAvailable($userId, $customerId, $executorId)
    {
        return $userId === $executorId ? true : false;
    }
}
