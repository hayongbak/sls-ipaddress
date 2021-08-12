<?php

require __DIR__ . '/vendor/autoload.php';

use Bref\Event\Http\HttpHandler;
use Bref\Context\Context;
use Bref\Event\Http\HttpRequestEvent;
use Bref\Event\Http\HttpResponse;


class Handler extends HttpHandler
{
    public function handleRequest(HttpRequestEvent $event, Context $context): HttpResponse
    {
        // Create response body with source IP address
        $responseBody = ["ip" => $event->toArray()['requestContext']['http']['sourceIp']];

        // Check if name query paramenter exist
        $queryParams = $event->getQueryParameters();
        if(isset($queryParams['name'])) {
            $responseBody["greeting"] = $queryParams['name'];
        }

        // Response headers
        $responseHeaders = [
            'x-hello-world' => "MB",
            'Content-Type' => 'application/json; charset=utf-8'
        ];

        return new HttpResponse(json_encode($responseBody, JSON_PRETTY_PRINT), $responseHeaders, 200);
    }
}

return new Handler();
