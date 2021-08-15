<?php


namespace TheScore\Web\Controller;


use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use TheScore\PlayerData\Repository\PlayerDataRepositoryInJsonFile;
use TheScore\PlayerData\UseCase\PlayerDataUseCase;
use Throwable;

class PlayersDataController
{

    private const DEFAULT_RECORDS_PER_PAGE = 25;

    public static function getRecordsAsJson(): Response
    {
        try {
            $repo = new PlayerDataRepositoryInJsonFile(__DIR__ . '/../../../data/rushing.json');
            $controller = new PlayerDataUseCase($repo);

            [$nameToFilter, $order, $page, $recordsPerPage] = PlayersDataController::extractParametersFromQueryString();
            $result = $controller->getRecordsAsJson($nameToFilter, $order, $page, $recordsPerPage);
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
        $page = $params['page'] ?? 1;
        $recordsPerPage = $params['recordsPerPage'] ?? self::DEFAULT_RECORDS_PER_PAGE;
        return [$nameToFilter, $order, $page, $recordsPerPage];
    }

    public static function getRecordsAsDownloadFile(): Response
    {
        try {
            $repo = new PlayerDataRepositoryInJsonFile(__DIR__ . '/../../../data/rushing.json');
            $controller = new PlayerDataUseCase($repo);

            [$nameToFilter, $order, $page, $recordsPerPage] = PlayersDataController::extractParametersFromQueryString();
            $result = $controller->getRecordsAsCsv($nameToFilter, $order, $page, $recordsPerPage);
        } catch (Throwable $e) {
            return ErrorController::generateErrorResponse($e);
        }

        $now = new DateTimeImmutable();
        return new Response(200, [
            'Content-Type' => 'text/csv, application/force-download, application/octet-stream, application/download',
            'Content-Disposition' => "attachment;filename=players_data_{$now->format('U')}.csv",
            'Content-Transfer-Encoding'=> 'binary',
        ], $result);
    }
}
