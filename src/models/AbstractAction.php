<?php
namespace htmlacademy\models;

abstract class AbstractAction
{
    abstract public static function getTitle();

    abstract public static function getName();

    abstract public static function isActionAvailable($userId, Task $task);
}
