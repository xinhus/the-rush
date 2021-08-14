<?php


namespace TheScore\PlayerData\Repository;


class PlayerDataRepository
{

    private string $fullPathToFile;

    public function __construct(string $fullPathToFile)
    {
        $this->fullPathToFile = $fullPathToFile;
    }

    public function getAllRecords(): array
    {
        $content = file_get_contents($this->fullPathToFile);

        return json_decode($content, true);
    }

    public function getAllRecordsByName(string $playersName): array
    {
        return array_filter(
            $this->getAllRecords(),
            fn($entry) => strpos($entry['Player'], $playersName) !== false
        );
    }

    public function getAllRecordsSortedByTotalRushingYards(bool $shouldOrderDesc): array
    {
        return $this->orderResultByField($this->getAllRecords(), 'Yds', $shouldOrderDesc);
    }

    public function getAllRecordsSortedByTotalRushingTouchdowns(bool $shouldOrderDesc): array
    {
        return $this->orderResultByField($this->getAllRecords(), 'TD', $shouldOrderDesc);
    }

    public function getAllRecordsSortedByLongestRush(bool $shouldOrderDesc): array
    {
        $allRecords = $this->getAllRecords();
        $allRecords = array_map(function ($record) {
            $record['Lng_Int'] = intval($record['Lng']);
            return $record;
        } , $allRecords);

        $allRecordsOrdered = $this->orderResultByField($allRecords, 'Lng_Int', $shouldOrderDesc);


        return array_map(function($record) {
            unset($record['Lng_Int']);
            return $record;
        }, $allRecordsOrdered);
    }

    private function orderResultByField(array $allRecords, string $fieldToOrder, bool $shouldOrderDesc): array {
        $totalRushingYards = array_column($allRecords, $fieldToOrder);
        $orderFlag = $shouldOrderDesc ? SORT_DESC : SORT_ASC;
        array_multisort($totalRushingYards, $orderFlag, $allRecords);
        return $allRecords;
    }
}
