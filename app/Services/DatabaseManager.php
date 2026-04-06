<?php
namespace App\Services;
use Exception;

class DatabaseManager
{
    public static function conectarCliente($empresa)
    {
        try {

           $capsule = require dirname(__DIR__,2) . '/bootstrap/eloquent.php';
           $capsule->getDatabaseManager()->purge('cliente');
            // crear nueva conexión dinámica
            $capsule->addConnection([
                'driver' => 'mysql',
                'host' => $empresa->host ?? '127.0.0.1',
                'port' => $empresa->port ?? 3306,
                'database' => $empresa->bd_cnn,
                'username' => $empresa->user_cnn,
                'password' => $empresa->pss_cnn,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'options' => [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]
            ], 'cliente');

            // establecer conexión activa
           $capsule->getDatabaseManager()->setDefaultConnection('cliente');

        } catch (Exception $e) {
            throw new Exception(
                "Error conectando a la base de datos del cliente: " . $e->getMessage()
            );
        }
    }
}