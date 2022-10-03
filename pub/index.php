<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Sol\Identifier\Random;
use Sol\Storage\Adapter\Memory;
use Sol\Storage\Storage;

require __DIR__ . '/../vendor/autoload.php';

// TODO: Create a new storage according to config (tbd).
$storage = new Storage(new Memory());
$randomId = new Random();

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    return $response;
});

/**
 * Create a resource with the given URL.
 * The MIME type of the resource is determined by the "Content-Type" header.
 */
$app->put('/{resource}', function (Request $request, Response $response, array $args) use ($storage) {
    $storage->write($args['resource'], $request->getBody()->getContents());
    return $response;
});

/**
 * Create a new resource without any name.
 * The MIME type of the resource is determined by the "Content-Type" header.
 * The generated name of the resource is contained in the response "Location" header.
 */
$app->post('/', function (Request $request, Response $response) use ($storage, $randomId) {
    $identifier = $randomId->generate();
    $storage->write($identifier, $request->getBody()->getContents());
    $response->withAddedHeader('Location', $request->getUri() . $identifier);
    return $response;
});

/**
 * Get a resource with the given URL.
 */
$app->get('/{resource}', function (Request $request, Response $response, array $args) use ($storage) {
    $response->getBody()->write($storage->read($args['resource']));
    return $response;
});

/**
 * Delete a resource with the given URL.
 */
$app->delete('/{resource}', function (Request $request, Response $response, array $args) use ($storage) {
    $storage->delete($args['resource']);
    return $response;
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
