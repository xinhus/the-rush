<?php


namespace Test\TheScore\Web\Controller;


use PHPUnit\Framework\TestCase;
use TheScore\Web\Controller\PlayersDataController;

class PlayersDataControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['QUERY_STRING'] = '';
    }

    public function testCanLoadFirstPlayer() {
        $_SERVER['QUERY_STRING'] = 'playerName=Joe+Banyard';
        $response = PlayersDataController::getRecordsAsJson();

        $expectedJsonResponse = <<<JSON
        [
            {
                "Player":"Joe Banyard",
                "Team":"JAX",
                "Pos":"RB",
                "Att":2,
                "Att/G":2,
                "Yds":7,
                "Avg":3.5,
                "Yds/G":7,
                "TD":0,
                "Lng":"7",
                "1st":0,
                "1st%":0,
                "20+":0,
                "40+":0,
                "FUM":0
            }
        ]
        JSON;
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertJsonStringEqualsJsonString($expectedJsonResponse, (string)$response->getBody());
    }

    public function testInvalidRequestShouldReturnErrorResponse() {
        $_SERVER['QUERY_STRING'] = 'order[InvalidField]=Joe+Banyard';

        $capture = tmpfile();
        $errorLog = stream_get_meta_data($capture)['uri'];
        $previousValue = ini_set('error_log', $errorLog);

        $response = PlayersDataController::getRecordsAsJson();
        $content = file_get_contents($errorLog);

        $expectedJsonResponse = <<<JSON
        {
            "message": "Oops, something wrong happened"
        }
        JSON;

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals($expectedJsonResponse, (string)$response->getBody());
        $this->assertStringContainsString('Unhandled match value of type string', $content);

        ini_set('error_log', $previousValue);
    }

    public function testCanExportSearch() {
        $_SERVER['QUERY_STRING'] = 'playerName=Joe+Banyard';
        $response = PlayersDataController::getRecordsAsDownloadFile();

        $expectedCsv = <<<JSON
        Player,Team,Pos,Att,Att/G,Yds,Avg,Yds/G,TD,Lng,1st,1st%,20+,40+,FUM
        Joe Banyard,JAX,RB,2,2,7,3.5,7,0,7,0,0,0,0,0
        
        JSON;
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/csv, application/force-download, application/octet-stream, application/download', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('attachment;filename=players_data_', $response->getHeaderLine('Content-Disposition'));
        $this->assertStringContainsString('.csv', $response->getHeaderLine('Content-Disposition'));
        $this->assertEquals('binary', $response->getHeaderLine('Content-Transfer-Encoding'));

        $this->assertEquals($expectedCsv, (string)$response->getBody());

    }

}
