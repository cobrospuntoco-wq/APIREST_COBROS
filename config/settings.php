<?php
/* use Psr\Container\ContainerInterface; */
use DI\Container;
return function (Container $container)
{
  $container->set('settings',function()
  {
    $db = require __DIR__ . '/../Config/database.php';

    return [
        "db"=>$db
    ];
  });
}; 