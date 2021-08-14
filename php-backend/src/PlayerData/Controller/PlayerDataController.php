<?php


namespace TheScore\PlayerData\Controller;


use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;

class PlayerDataController
{

    private PlayerDataRepositoryInJsonFile $repository;

    public function __construct(PlayerDataRepositoryInJsonFile $repository)
    {
        $this->repository = $repository;
    }

    public function getRecords(string $nameToFilter, array $order): string
    {
        $allRecords = $this->repository->getRecords($nameToFilter, $order);
        return json_encode(array_values($allRecords), JSON_PRETTY_PRINT);
    }
}
