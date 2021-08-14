<?php


namespace Test\TheScore\PlayerData\Repository;


use PHPUnit\Framework\TestCase;
use TheScore\PlayerData\Repository\PlayerDataRepository;

class PlayerDataRepositoryTest extends TestCase
{

    protected function tearDown(): void
    {
        parent::tearDown();
        JsonFileFactory::deleteAllFilesGenerated();
    }


    public function testCanCreateRepositoryAndLoadFile()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->generate();


        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecords();

        $expectedResult = [PlayersDataConst::JoeBanyard];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanCreateRepositoryWithMultipleRecords()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->generate();

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecords();

        $expectedResult = [PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanFilterByName()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->generate();

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsByName('Joe');

        $expectedResult = [PlayersDataConst::JoeBanyard];

        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingYardsDesc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->generate();

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByTotalRushingYards(true);

        $expectedResult = [PlayersDataConst::JoeBanyard, PlayersDataConst::ShaunHill];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByTotalRushingYardsAsc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->generate();

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByTotalRushingYards(false);

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

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByTotalRushingTouchdowns(true);

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

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByTotalRushingTouchdowns(false);

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

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByLongestRush(true);

        $expectedResult = [PlayersDataConst::MarkIngram76, PlayersDataConst::MarkIngram, PlayersDataConst::MarkIngram74];
        $this->assertEquals($expectedResult, $result);
    }

    public function testCanSortByLongestRushAsc()
    {
        $filePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->generate();

        $repo = new PlayerDataRepository($filePath);
        $result = $repo->getAllRecordsSortedByLongestRush(false);

        $expectedResult = [PlayersDataConst::MarkIngram74, PlayersDataConst::MarkIngram, PlayersDataConst::MarkIngram76];
        $this->assertEquals($expectedResult, $result);
    }

}
