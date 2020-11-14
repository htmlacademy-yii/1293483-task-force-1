<?php
declare(strict_types = 1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use htmlacademy\data\CSVToSQLConverter;
use htmlacademy\exceptions\SourceFileException;

$directory = new FilesystemIterator('data');

foreach ($directory as $fileInfo) {
    $csvToSqlConverter = new CSVToSQLConverter($fileInfo->getPathname(), 'requests');

    try {
        $csvToSqlConverter->createSQLFromCSV();
    } catch (SourceFileException $e) {
        error_log('Не удалось обработать csv файл: ' . $e->getMessage());
    }
}
