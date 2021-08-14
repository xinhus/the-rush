<?php


namespace Test\TheScore\PlayerData\Controller;


use Test\TheScore\PlayerData\Repository\JsonFileFactory;
use Test\TheScore\PlayerData\Repository\PlayersDataConst;
use Test\TheScore\TheScoreTestCase;
use TheScore\PlayerData\Controller\PlayerDataController;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;

class PlayerDataControllerTest extends TheScoreTestCase
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
        $controller = new PlayerDataController($repository);
        $result = $controller->getRecords('', []);

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
        $controller = new PlayerDataController($repository);
        $result = $controller->getRecords('Ingram', []);

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
        $controller = new PlayerDataController($repository);
        $result = $controller->getRecords(
            'Ingram',
            [
                'LongestRush' => 'Asc'
            ]
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
