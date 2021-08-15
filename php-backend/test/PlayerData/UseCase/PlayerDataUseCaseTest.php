<?php


namespace Test\TheScore\PlayerData\UseCase;


use Test\TheScore\PlayerData\Repository\JsonFileFactory;
use Test\TheScore\PlayerData\Repository\PlayersDataConst;
use Test\TheScore\TheScoreTestCase;
use TheScore\PlayerData\UseCase\PlayerDataUseCase;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;

class PlayerDataUseCaseTest extends TheScoreTestCase
{
    private string $jsonFilePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jsonFilePath = JsonFileFactory::getBuilder()
            ->addRecord(PlayersDataConst::JoeBanyard)
            ->addRecord(PlayersDataConst::ShaunHill)
            ->addRecord(PlayersDataConst::LanceDunbar)
            ->addRecord(PlayersDataConst::MarkIngram)
            ->addRecord(PlayersDataConst::MarkIngram74)
            ->addRecord(PlayersDataConst::MarkIngram76)
            ->generate();
    }

    public function testCanRetrieveAllRecords()
    {
        $repository = new PlayerDataRepositoryInJsonFile($this->jsonFilePath);
        $controller = new PlayerDataUseCase($repository);
        $result = $controller->getRecordsAsJson('', [], 1, 25);

        $expectedData = [
            PlayersDataConst::JoeBanyard,
            PlayersDataConst::ShaunHill,
            PlayersDataConst::LanceDunbar,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram76,
        ];
        $expectedJson = json_encode($expectedData, JSON_PRETTY_PRINT);

        $this->assertSame($expectedJson, $result);
    }

    public function testCanFilterByName()
    {
        $repository = new PlayerDataRepositoryInJsonFile($this->jsonFilePath);
        $controller = new PlayerDataUseCase($repository);
        $result = $controller->getRecordsAsJson('Ingram', [], 1, 25);

        $expectedData = [
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram76,
        ];
        $expectedJson = json_encode($expectedData, JSON_PRETTY_PRINT);

        $this->assertSame($expectedJson, $result);
    }

    public function testFilterByNameOrderByLongestRushAsc()
    {
        $repository = new PlayerDataRepositoryInJsonFile($this->jsonFilePath);
        $controller = new PlayerDataUseCase($repository);
        $result = $controller->getRecordsAsJson(
            'Ingram',
            [
                'LongestRush' => 'Asc'
            ],
            1,
            25
        );

        $expectedData = [
            PlayersDataConst::MarkIngram74,
            PlayersDataConst::MarkIngram,
            PlayersDataConst::MarkIngram76,
        ];
        $expectedJson = json_encode($expectedData, JSON_PRETTY_PRINT);

        $this->assertSame($expectedJson, $result);
    }
}
