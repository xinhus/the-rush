<?php


namespace TheScore\PlayerData\Repository;


class PlayerDataRepositoryInJsonFile
{

    private string $fullPathToFile;

    public function __construct(string $fullPathToFile)
    {
        $this->fullPathToFile = $fullPathToFile;
    }

    public function getRecords(string $nameToFilter, array $order, int $page, int $recordsPerPage): array
    {
        $records = $this->loadRecordFromFile();
        $resultsFiltered = $this->filterByName($records, $nameToFilter);
        $resultsOrdered = $this->orderRecords($order, $resultsFiltered);
        $resultsPaginated = $this->paginateRecords($page, $recordsPerPage, $resultsOrdered);

        return $this->removeLogicFields($resultsPaginated);
    }

    private function loadRecordFromFile(): array
    {
        $content = file_get_contents($this->fullPathToFile);
        return json_decode($content, true);
    }

    private function filterByName(array $records, string $playersName): array
    {
        return array_values(array_filter( $records,fn($entry) => str_contains($entry['Player'], $playersName)));
    }

    private function orderRecords(array $order, array $records): array
    {
        $fieldsToOrder = [];
        foreach ($order as $fieldName => $flag) {
            $fieldName = str_replace(' ', '', $fieldName);
            $records = $this->createInternalFieldsToFilter($fieldName, $records);
            $fieldsToOrder = $this->addFieldToOrderArray($fieldName, $flag, $fieldsToOrder);
        }

        return empty($fieldsToOrder)
            ? $records
            : array_values($this->orderResultByField($records, $fieldsToOrder));
    }

    private function createNumericFieldBasedOnOtherField(array $records, string $newFieldName, string $baseField): array
    {
        return array_map(
            function ($record) use ($newFieldName, $baseField) {
                $record[$newFieldName] = floatval(preg_replace("/((?![0-9\-.]).)*/", '', $record[$baseField]));
                return $record;
            },
            $records
        );
    }

    private function orderResultByField(array $allRecords, array $order): array {
        $array_to_order = [];
        $allRecords = array_values($allRecords);

        foreach ($allRecords as $key => $record) {
            $allRecords[$key]["Position"] = $key;
        }
        $order["Position"] = false;
        foreach ($order as $fieldName => $shouldOrderDesc) {
            $columnToFilter = array_column($allRecords, $fieldName);
            $orderFlag = $shouldOrderDesc ? SORT_DESC : SORT_ASC;
            array_push($array_to_order, $columnToFilter, $orderFlag);
        }

        array_push($array_to_order, $allRecords);
        array_multisort(...$array_to_order);

        return array_pop($array_to_order);
    }

    private function removeLogicFields(array $records): array
    {
        return array_map(
            function ($record) {
                unset($record['Lng_Int']);
                unset($record['Yds_Int']);
                unset($record['TD_Int']);
                unset($record['Position']);
                return $record;
            },
            $records
        );
    }

    private function createInternalFieldsToFilter(string $fieldName, array $records): array
    {
        return match (strtolower($fieldName)) {
            'totalrushingtouchdowns' => $this->createNumericFieldBasedOnOtherField($records, 'TD_Int', 'TD'),
            'totalrushingyards' => $this->createNumericFieldBasedOnOtherField($records, 'Yds_Int', 'Yds'),
            'longestrush' => $this->createNumericFieldBasedOnOtherField($records, 'Lng_Int', 'Lng'),
        };
    }

    private function addFieldToOrderArray(string $fieldName, string $flagOrder, array $fieldsToOrder): array
    {
        $shouldOrderDesc = strtoupper($flagOrder) === 'DESC';
        $fieldNameR = match (strtolower($fieldName)) {
            'totalrushingtouchdowns' => 'TD',
            'totalrushingyards' => 'Yds_Int',
            'longestrush' => 'Lng_Int',
        };
        $fieldsToOrder[$fieldNameR] = $shouldOrderDesc;
        return $fieldsToOrder;
    }

    private function paginateRecords(int $page, int $recordsPerPage, array $resultsOrdered): array
    {
        $initial = ($page - 1) * $recordsPerPage;
        $max = $page * $recordsPerPage;

        $resultsOrdered = array_values(
            array_filter(
                $resultsOrdered,
                fn($position) => $initial <= $position && $position < $max,
                ARRAY_FILTER_USE_KEY
            )
        );
        return $resultsOrdered;
    }
}
