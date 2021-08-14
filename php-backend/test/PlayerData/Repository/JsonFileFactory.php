<?php


namespace Test\TheScore\PlayerData\Repository;


class JsonFileFactory
{

    private static array $filesToDelete = [];
    private array $data = [];

    private function __construct()
    {
    }

    public static function getBuilder()
    {
        return new self();
    }

    public function addRecord(array $record): JsonFileFactory
    {
        array_push($this->data, $record);
        return $this;
    }

    public function generate()
    {
        $filePath = __DIR__ . '/fake_data' . microtime(true) . '.json';

        array_push(self::$filesToDelete, $filePath);

        file_put_contents($filePath, json_encode($this->data));
        return $filePath;
    }

    public static function deleteAllFilesGenerated(): void
    {
        array_map(fn($filePath) => unlink($filePath), self::$filesToDelete);
        self::$filesToDelete = [];
    }
}
