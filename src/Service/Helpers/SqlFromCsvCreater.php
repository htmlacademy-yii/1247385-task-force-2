<?php
namespace Taskforce\Service\Helpers;

use Taskforce\Exceptions;
use Taskforce\Exceptions\SourceFileException;
use Taskforce\Exceptions\FileFormatException;

class SqlFromCsvCreater
{
    private string $csvFile;
    private \SplFileObject $fileObject;

    private array $result = [];

    private array $columns = [];

    public function __construct(string $csvFile, array $columns = [])
    {
        $rootPath = dirname(__DIR__, 2);

        $this->csvFile = $rootPath . $csvFile;
        $this->columns = $columns;
    }

    public function importCsv(): array
    {
        if (!file_exists($this->csvFile)) {
            throw new Exceptions\SourceFileException("Файл не существует");
        }

        if (pathinfo($this->csvFile, PATHINFO_EXTENSION) !== 'csv') {
            throw new Exceptions\FileFormatException("Допустимый формат для загрузки - csv");
        }

        try {
            $this->fileObject = new \SplFileObject($this->csvFile);
        } catch (\RuntimeException $exception) {
            throw new Exceptions\SourceFileException("Не удалось открыть файл на чтение");
        }

        $this->fileObject->setFlags(
            \SplFileObject::READ_CSV
            | \SplFileObject::READ_AHEAD
            | \SplFileObject::SKIP_EMPTY
            | \SplFileObject::DROP_NEW_LINE
        );

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

        return $this->result;
    }

    private function getNextLine(): ?iterable {
        // пропустим первую строку, заголовки передаем в $columns
        $this->fileObject->fgetcsv();

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
    }

    private function getFileName(): string
    {
        return $this->fileObject->getBasename('.'.$this->fileObject->getExtension());
    }

    public function createSqlFile(): void
    {
        try {
            $data = $this->importCsv();
        } catch (SourceFileException $e) {
            echo "Не удалось обработать csv файл: " . $e->getMessage();
            return;
        } catch (FileFormatException $e) {
            echo "Неверное расширение файла: " . $e->getMessage();
            return;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return;
        }

        $sqlFileName = $this->getFileName();
        $file = new \SplFileObject($sqlFileName . '.sql', 'w');

        foreach ($data as $dataString) {
            $values = '"' . implode('","', $dataString) . '"';

            $string = 'INSERT INTO ' . $sqlFileName . ' (' . implode(",", $this->columns) .') '
                        . 'VALUES (' . $values . ');' . PHP_EOL;

            $file->fwrite($string);
        }
    }

}
