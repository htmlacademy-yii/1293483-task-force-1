<?php
namespace htmlacademy\models;

class RespondAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Откликнуться';
    }

    public function getName()
    {
        return 'respond';
    }

    public  function isActionAvailable($userId, $customerId, $executorId)
    {
        return $userId === $executorId ? true : false;
    }
}
