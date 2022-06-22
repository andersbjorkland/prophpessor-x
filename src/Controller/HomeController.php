<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class HomeController
{
    public function __invoke(ServerRequestInterface $request)
    {
        return Response::plaintext("Hello wörld!\n");
    }
}