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
        $result = $repo->getRecords('', []);

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
        $result = $repo->getRecords('', []);

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
        $result = $repo->getRecords('Joe', []);

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
        $result = $repo->getRecords('', ['TotalRushingYards' => 'DESC']);

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
        $result = $repo->getRecords('', ['TotalRushingYards' => 'ASC']);

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
        $result = $repo->getRecords('', ['TotalRushingTouchdowns' => 'DESC']);

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
        $result = $repo->getRecords('', ['TotalRushingTouchdowns' => 'ASC']);

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
        $result = $repo->getRecords('', ['LongestRush' => 'DESC']);

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
        $result = $repo->getRecords('', ['LongestRush' => 'ASC']);

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
            ]
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
            ]
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
}
