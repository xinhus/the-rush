<?php


namespace TheScore\PlayerData\UseCase;


use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;

class PlayerDataUseCase
{

    private PlayerDataRepositoryInJsonFile $repository;

    public function __construct(PlayerDataRepositoryInJsonFile $repository)
    {
        $this->repository = $repository;
    }

    public function getRecordsAsJson(string $nameToFilter, array $order): string
    {
        $allRecords = $this->repository->getRecords($nameToFilter, $order);
        return json_encode(array_values($allRecords), JSON_PRETTY_PRINT);
    }

    public function getRecordsAsCsv(mixed $nameToFilter, mixed $order)
    {
        $allRecords = $this->repository->getRecords($nameToFilter, $order);
        $csv = '';
        foreach ($allRecords as $record) {
            if (empty($csv)) {
                $csvHeader = array_keys($record);
                $csv .= implode(',', $csvHeader) . PHP_EOL;
            }

            $csvValues = array_values($record);
            $csv .= implode(',', $csvValues) . PHP_EOL;
        }
        return $csv;
    }
}
