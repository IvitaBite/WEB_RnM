<?php
declare(strict_types=1);

use App\Response;
use App\Router\Router;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Carbon\Carbon;

require_once __DIR__ . '/../vendor/autoload.php';

$currentDateTime = Carbon::now();

$loader = new FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new Environment($loader);


$routeInfo = Router::dispatch();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $vars = $routeInfo[2];

        [$controller, $method] = $routeInfo[1];

        $response = (new $controller)->{$method}($vars);

        if ($response instanceof Response) {
            /** @var Response $response */
            echo $twig->render($response->getViewName() . '.twig', $response->getData());
        }
        break;
}
