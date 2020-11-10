<?php
namespace htmlacademy\data;

use htmlacademy\exceptions\SourceFileException;

class CSVToSQLConverter
{
    public $fileName;
    public $directory;
    public $CSVFileObject;

    /**
     * Конструктор
     *
     * @param string $fileName Название файла для конвертирования в sql
     * @param string $directory Название папки, в которую будут помещены sql файлы
     */
    public function __construct(string $fileName, string $directory)
    {
        $this->fileName = $fileName;
        $this->directory = $directory;
    }

    /**
     * Создание sql файла из csv файла
     *
     * @throws
     * @return void
     */
    public function createSQLFromCSV(): void
    {
        if (!file_exists($this->fileName)) {
            throw new SourceFileException('Файл не существует');
        }

        if (!file_exists($this->directory)) {
            mkdir($this->directory);
        }

        $tableName = basename($this->fileName, '.csv');

        try {
            $this->CSVFileObject = new \SplFileObject($this->fileName, 'r');
        } catch (\RuntimeException $exception) {
            throw new SourceFileException('Не удалось открыть файл на чтение');
        }

        $this->CSVFileObject->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);

        try {
            $SQLFileObject = new \SplFileObject("$this->directory/$tableName.sql", 'w');
        } catch (\RuntimeException $exception) {
            throw new SourceFileException('Не удалось создать или открыть файл на запись');
        }

        $columnHeaders = implode(', ', $this->getColumnHeaders());

        $SQLFileObject->fwrite("INSERT INTO $tableName ($columnHeaders) VALUES");
        $isFirstValues = true;

        foreach ($this->getNextLine() as $line) {
            $values = ",\n('" . implode("', '", $line) . "')";

            if ($isFirstValues) {
                $values = ltrim($values, ',');
                $isFirstValues = false;
            }

            $SQLFileObject->fwrite($values);
        }

        $SQLFileObject->fwrite(';');
    }

    /**
     * Получение заголовков столбцов из файла
     *
     * @return array | null
     */
    public function getColumnHeaders(): ?array
    {
        $data = $this->CSVFileObject->fgetcsv();

        return $data;
    }

    /**
     * Получение строки из файла
     *
     * @return iterable | null
     */
    public function getNextLine(): ?iterable
    {
        $result = null;

        while (!$this->CSVFileObject->eof()) {
            $line = $this->CSVFileObject->fgetcsv();

            if (empty($line)) {
                continue;
            }

            yield $line;
        }

        return $result;
    }
}
