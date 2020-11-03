<?php
namespace htmlacademy\models;

abstract class AbstractAction
{
    abstract public static function getTitle(): string;

    abstract public static function getName(): string;

    abstract public static function isActionAvailable(int $userId, Task $task): bool;
}
