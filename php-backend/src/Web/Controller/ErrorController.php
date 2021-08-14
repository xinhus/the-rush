<?php


namespace TheScore\Web\Controller;



use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

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
}
