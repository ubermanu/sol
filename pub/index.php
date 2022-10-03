<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    return $response;
});

$app->get('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
    $response->getBody()->write("resource filename: $filename");
    return $response;
});

$app->run();
