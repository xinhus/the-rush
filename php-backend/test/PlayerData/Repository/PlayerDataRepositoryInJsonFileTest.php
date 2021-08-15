<?php


namespace Test\TheScore\PlayerData\Repository;

use Test\TheScore\TheScoreTestCase;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;

class PlayerDataRepositoryInJsonFileTest extends TheScoreTestCase
{
    public function testCanCreateRepositoryAndLoadFile()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->generate();


        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', [], 1, 25);

        $expectedResult = [PlayersDataConst::JoeBanyard];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanCreateRepositoryWithMultipleRecords()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', [], 1, 25);

        $expectedResult = [PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanFilterByName()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('Joe', [], 1, 25);

        $expectedResult = [PlayersDataConst::JoeBanyard];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingYardsDesc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->addRecord(PlayersDataConst::MarkIngram76HigherYds)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['TotalRushingYards' => 'DESC'], 1, 25);

        $expectedResult = [PlayersDataConst::MarkIngram76HigherYds, PlayersDataConst::MarkIngram76];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingYardsAsc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['TotalRushingYards' => 'ASC'], 1, 25);

        $expectedResult = [PlayersDataConst::ShaunHill, PlayersDataConst::JoeBanyard];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingTouchdownsDesc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::LanceDunbar)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['TotalRushingTouchdowns' => 'DESC'], 1, 25);

        $expectedResult = [PlayersDataConst::LanceDunbar, PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingTouchdownsAsc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::LanceDunbar)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['TotalRushingTouchdowns' => 'ASC'], 1, 25);

        $expectedResult = [PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill, PlayersDataConst::LanceDunbar];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByLongestRushDesc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['LongestRush' => 'DESC'], 1, 25);

        $expectedResult = [
            PlayersDataConst::MarkIngram76,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram74
        ];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByLongestRushAsc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->generate();

        $repo = new PlayerDataRepositoryInJsonFile($filePath);
        $result = $repo->getRecords('', ['LongestRush' => 'ASC'], 1, 25);

        $expectedResult = [
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram76
        ];
        $this->assertEquals($expectedResult, $result);
    }

    public function testFilterByNameOrderByLongestRushAscTotalRushingYardsDesc()
    {

        $jsonFilePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->addRecord(PlayersDataConst::MarkIngram76HigherYds)
            ->generate();

        $repository = new PlayerDataRepositoryInJsonFile($jsonFilePath);
        $result = $repository->getRecords(
            '',
            [
                'LongestRush' => 'Asc',
                'TotalRushingYards' => 'Desc',
            ],
            1,
            25
        );

        $expectedData = [
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram76HigherYds,
            PlayersDataConst::MarkIngram76,
        ];

        $this->assertEquals($expectedData, $result);
    }

    public function testFilterByNameOrderByLongestRushAscTotalRushingYardsDescTotalRushingTouchdownsAsc()
    {

        $jsonFilePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->addRecord(PlayersDataConst::MarkIngram76HigherYds)
            ->addRecord(PlayersDataConst::MarkIngram76HigherYdsHigherRushingTouchdowns)
            ->generate();

        $repository = new PlayerDataRepositoryInJsonFile($jsonFilePath);
        $result = $repository->getRecords(
            '',
            [
                'LongestRush' => 'Asc',
                'TotalRushingYards' => 'Desc',
                'TotalRushingTouchdowns' => 'DESC',
            ],
            1,
            25
        );

        $expectedData = [
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram76HigherYdsHigherRushingTouchdowns,
            PlayersDataConst::MarkIngram76HigherYds,
            PlayersDataConst::MarkIngram76,
        ];

        $this->assertEquals($expectedData, $result);
    }


    public function testCanOrderByFieldNameWithSpace()
    {

        $jsonFilePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->generate();

        $repository = new PlayerDataRepositoryInJsonFile($jsonFilePath);
        $result = $repository->getRecords(
            '',
            [
                'Longest Rush' => 'Asc',
            ],
            1,
            25
        );

        $expectedData = [
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram76,
        ];

        $this->assertEquals($expectedData, $result);
    }

    /**
     * @dataProvider paginationCases
     */
    public function testRespectPagination(JsonFileFactory $jsonFileFactory, int $pageNumber, int $recordPerPage, array $expectedArray) {
        $jsonFilePath = $jsonFileFactory->generate();
        $repository = new PlayerDataRepositoryInJsonFile($jsonFilePath);
        $result = $repository->getRecords('', [], $pageNumber, $recordPerPage);
        $this->assertEquals($expectedArray, $result);
    }

    public function paginationCases(): array
    {
        $jsonBuilder = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::LanceDunbar)
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::MarkIngram76HigherYdsHigherRushingTouchdowns);
        return [
            ['file' => $jsonBuilder, 'page' => 1, 'recordsPerPage' => 1, 'expectedArray' => [PlayersDataConst::JoeBanyard]],
            ['file' => $jsonBuilder, 'page' => 2, 'recordsPerPage' => 3, 'expectedArray' => [PlayersDataConst::ShaunHill, PlayersDataConst::LanceDunbar, PlayersDataConst::MarkIngram]],
            ['file' => $jsonBuilder, 'page' => 2, 'recordsPerPage' => 2, 'expectedArray' => [PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill]],
            ['file' => $jsonBuilder, 'page' => 3, 'recordsPerPage' => 4, 'expectedArray' => [PlayersDataConst::MarkIngram76HigherYdsHigherRushingTouchdowns]],
            ['file' => $jsonBuilder, 'page' => 4, 'recordsPerPage' => 4, 'expectedArray' => []],
        ];
    }
}
