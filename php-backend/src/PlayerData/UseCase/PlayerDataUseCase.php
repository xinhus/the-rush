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

    public function getRecords(string $nameToFilter, array $order): string
    {
        $allRecords = $this->repository->getRecords($nameToFilter, $order);
        return json_encode(array_values($allRecords), JSON_PRETTY_PRINT);
    }
}
