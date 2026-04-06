<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$config = require __DIR__.'/../config/database.php';

foreach ($config['connections'] as $name => $connection) {
    $capsule->addConnection($connection, $name);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;