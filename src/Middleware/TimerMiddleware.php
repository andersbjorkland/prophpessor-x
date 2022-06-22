<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TimerMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $start = microtime(true);
        $response = $next($request);

        assert($response instanceof ResponseInterface);
        $end = microtime(true);

        $contents = $response->getBody()->getContents();
        $response->getBody()->write(
            $response->getBody()->getContents() .
            " \nTime: " . ($end - $start) . "\n"
        );
        return $response;
    }
}