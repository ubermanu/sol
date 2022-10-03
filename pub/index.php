<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    return $response;
});

/**
 * Create a resource with the given URL.
 * The MIME type of the resource is determined by the "Content-Type" header.
 */
$app->put('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
    // TODO: Create the resource with the given filename.
    $response->getBody()->write("resource filename: $filename");
    return $response;
});

/**
 * Create a new resource without any name.
 * The MIME type of the resource is determined by the "Content-Type" header.
 * The generated name of the resource is contained in the response "Location" header.
 */
$app->post('/', function (Request $request, Response $response) {
    // TODO: Create the resource with a generated filename.
    return $response;
});

/**
 * Get a resource with the given URL.
 */
$app->get('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
    // TODO: get the resource from the filesystem
    $response->getBody()->write("resource filename: $filename");
    return $response;
});

/**
 * Delete a resource with the given URL.
 */
$app->delete('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
});

/**
 * Update a resource with the given URL.
 * The modification handler is determined by the "Content-Type" header.
 */
$app->patch('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
    // TODO: Implement the resource update.
    return $response;
});

/**
 * Retrieve resources communication options.
 */
$app->options('/{resource}', function (Request $request, Response $response, array $args) {
    $filename = $args['resource'];
    // TODO: Implement the resource options.
    return $response;
});

$app->run();
