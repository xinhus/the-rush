<?php


namespace Test\TheScore\Web\Controller;


use Test\TheScore\TheScoreTestCase;
use TheScore\Web\Controller\ErrorController;

class ErrorControllerTest extends TheScoreTestCase
{
    public function testRaise404() {
        $response = ErrorController::raise404();

        $expectedJsonResponse = <<<JSON
        {
            "message": "Resource Not found"
        }
        JSON;

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals($expectedJsonResponse, (string)$response->getBody());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
