<?php

namespace App\Controller;

use App\Database\DBConnection;
use App\Repository\ArticleRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\MySQL\QueryResult;

class HomeController
{
    public function __invoke(ServerRequestInterface $request)
    {
        $connection = (new DBConnection())->getDb();
        $repository = new ArticleRepository($connection);
        return $repository->initialize()->then( function (QueryResult $result) {
            $var = true;
            return Response::plaintext("Hello wörld!\n");
        });

    }
}