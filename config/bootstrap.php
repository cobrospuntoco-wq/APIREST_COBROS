<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use Selective\BasePath\BasePathMiddleware;

require_once __DIR__  .'/../vendor/autoload.php';
require_once __DIR__.'/../bootstrap/eloquent.php';
$container = new Container();
$settings = require_once __DIR__.'/settings.php';
$settings($container);
$app = SlimAppFactory::create($container);


$app->add(new \App\Middleware\TenantDatabaseMiddleware());
$app->add(new BasePathMiddleware($app));
$middleware = require_once __DIR__ . '/../app/Middleware/middleware.php';
$middleware($app);
// Add Slim routing middleware
$app->addRoutingMiddleware();
//$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$routes = require_once  __DIR__ .'/routes.php'; $routes($app);
$app->run();