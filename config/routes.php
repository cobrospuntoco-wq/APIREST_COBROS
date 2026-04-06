<?php
declare(strict_types=1);
namespace App\config;
use Slim\App;
return function ($app): void {
$rutas=[    
'routesAppLogin',
'routesAppAdmin',
'routesAppMovil',
'routesVentas',
'routesMdn'
];
            foreach($rutas as $ruta)
            {       
                   $router=require __DIR__ . "/../app/Routes/{$ruta}.php";
                   $router($app);
            }
};