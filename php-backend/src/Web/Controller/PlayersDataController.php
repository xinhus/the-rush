<?php


namespace TheScore\Web\Controller;


use GuzzleHttp\Psr7\Response;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;
use TheScore\PlayerData\UseCase\PlayerDataUseCase;
use Throwable;

class PlayersDataController
{

    public static function getRecordsAsJson(): Response
    {
        try {
            $repo = new PlayerDataRepositoryInJsonFile(__DIR__ . '/../../../data/rushing.json');
            $controller = new PlayerDataUseCase($repo);

            [$nameToFilter, $order] = PlayersDataController::extractParametersFromQueryString();
            $result = $controller->getRecordsAsJson($nameToFilter, $order);
        } catch (Throwable $e) {
            return ErrorController::generateErrorResponse($e);
        }
        return new Response(200, ['Content-Type' => 'application/json'], $result);
    }

    private static function extractParametersFromQueryString(): array
    {
        $params = [];
        parse_str($_SERVER['QUERY_STRING'], $params);

        $nameToFilter = $params['playerName'] ?? '';
        $order = $params['order'] ?? [];
        return [$nameToFilter, $order];
    }

    public static function getRecordsAsDownloadFile(): Response
    {
        try {
            $repo = new PlayerDataRepositoryInJsonFile(__DIR__ . '/../../../data/rushing.json');
            $controller = new PlayerDataUseCase($repo);

            [$nameToFilter, $order] = PlayersDataController::extractParametersFromQueryString();
            $result = $controller->getRecordsAsCsv($nameToFilter, $order);
        } catch (Throwable $e) {
            return ErrorController::generateErrorResponse($e);
        }

        $now = new \DateTimeImmutable();
        return new Response(200, [
            'Content-Type' => 'text/csv, application/force-download, application/octet-stream, application/download',
            'Content-Disposition' => "attachment;filename=players_data_{$now->format('U')}.csv",
            'Content-Transfer-Encoding'=> 'binary',
        ], $result);
    }
}
