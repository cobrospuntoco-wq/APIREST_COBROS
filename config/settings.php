<?php
/* use Psr\Container\ContainerInterface; */
use DI\Container;
return function (Container $container)
{
  $container->set('settings',function()
  {
    $db = require __DIR__ . '/../config/database.php';

    return [
        "db"=>$db
    ];
  });
}; 