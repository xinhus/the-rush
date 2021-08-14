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
        $repo = new PlayerDataRepositoryInJsonFile(__DIR__ . '/../../../data/rushing.json');
        $controller = new PlayerDataUseCase($repo);

        [$nameToFilter, $order] = self::extractParametersFromQueryString();

        try {
            $result = $controller->getRecords($nameToFilter, $order);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());

            $responseMessage = [
                'message' => 'Oops, something wrong happened',
            ];
            return new Response(500, ['Content-Type' => 'application/json'], json_encode($responseMessage, JSON_PRETTY_PRINT));
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
        $now = new \DateTimeImmutable();
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::getRecordsAsJson()
            ->withAddedHeader('Content-Type', 'application/force-download')
            ->withAddedHeader('Content-Type', 'application/octet-stream')
            ->withAddedHeader('Content-Type', 'application/download')
            ->withHeader('Content-Disposition', "attachment;filename=players_data_{$now->format('U')}.json")
            ->withHeader('Content-Transfer-Encoding', "binary");
    }
}
