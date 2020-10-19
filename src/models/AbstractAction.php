<?php
namespace htmlacademy\models;

abstract class AbstractAction
{
    abstract public function getTitle();

    abstract public function getName();

    abstract public function isActionAvailable($userId, $customerId, $executorId);
}
