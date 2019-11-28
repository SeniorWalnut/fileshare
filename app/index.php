<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'src/dbconfig.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

// Containers goes here
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $this->logger->addInfo('Something interesting happened');
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();
