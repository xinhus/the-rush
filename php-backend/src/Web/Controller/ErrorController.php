<?php


namespace TheScore\Web\Controller;



use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ErrorController
{

    public static function raise404(): ResponseInterface
    {
        $responseMessage = [
            'message' => 'Resource Not found',
        ];
        $responseBody = json_encode($responseMessage, JSON_PRETTY_PRINT);

        return new Response(404, ['Content-Type' => 'application/json'], $responseBody);
    }

    public static function generateErrorResponse(Throwable $e): Response
    {
        error_log($e->getMessage());
        error_log($e->getTraceAsString());

        $responseMessage = [
            'message' => 'Oops, something wrong happened',
        ];
        return new Response(
            500,
            ['Content-Type' => 'application/json'],
            json_encode($responseMessage, JSON_PRETTY_PRINT)
        );
    }
}
