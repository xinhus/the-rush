<?php

include_once '../vendor/autoload.php';

use TheScore\Web\Controller\ErrorController;
use TheScore\Web\Controller\PlayersDataController;

$response = match ($_SERVER['REDIRECT_URL'] ?? '') {
    '/playersData' => PlayersDataController::getRecordsAsJson(),
    '/playersData/export' => PlayersDataController::getRecordsAsDownloadFile(),
    default => ErrorController::raise404()
};

$headers = $response->getHeaders();
foreach ($headers as $name => $header) {
    header("{$name}: {$header[0]}");
}
http_response_code($response->getStatusCode());
echo $response->getBody();
