<?php

include_once '../vendor/autoload.php';

use TheScore\PlayerData\Controller\PlayerDataController;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;


match ($_SERVER['REDIRECT_URL'] ?? '') {
    '/playersData' => callPlayerData(),
    default => raise_404()
};

function callPlayerData(): void {
    header("Content-Type: application/json");
    $repo = new PlayerDataRepositoryInJsonFile( __DIR__ . '/../data/rushing.json');
    $controller = new PlayerDataController($repo);
    $params = [];
    parse_str( $_SERVER['QUERY_STRING'], $params);

    $nameToFilter = $params['playerName'] ?? '';
    $order = $params['order'] ?? [];

    try {
        http_response_code(200);
        echo $controller->getRecords($nameToFilter, $order);
    } catch (Throwable $e) {
        $response = [
            'message' => 'Oops, something wrong happened',
        ];
        http_response_code(500);
        echo json_encode($response, JSON_PRETTY_PRINT);
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
    }
}

function raise_404(): void {
    header("Content-Type: application/json");
    http_response_code(404);
    $response = [
        'message' => 'Resource Not found',
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
}
