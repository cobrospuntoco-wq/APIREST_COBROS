<?php

namespace App\Helpers;
use App\Models\mdn\PaisModel;
use DateTime;
use DateTimeZone;

class DataTimeZona
{
    public static function generarFechaExpira($Id, $intervalo = '+1 hour')
    {
        $Pais = PaisModel::select("*")->where(["id"=>$Id])->first();
        $zona = !empty($Pais->timezone) ? $Pais->timezone : 'UTC';
        // Validar zona
        if (!in_array($zona, timezone_identifiers_list())) {
            $zona = 'UTC';
        }

        $fecha = new DateTime("now", new DateTimeZone($zona));
        $fecha->modify($intervalo);

        return $fecha->format('Y-m-d H:i:s');
    }

    public static function fechahoy($zona = 'UTC')
    {
        if (!in_array($zona, timezone_identifiers_list())) {
            $zona = 'UTC';
        }

        return (new DateTime("now", new DateTimeZone($zona)))
            ->format('Y-m-d H:i:s');
    }

       public static function fecha($zona = 'UTC')
    {
        if (!in_array($zona, timezone_identifiers_list())) {
            $zona = 'UTC';
        }

        return (new DateTime("now", new DateTimeZone($zona)))
            ->format('Y-m-d');
    }

    public static function expirado($fecha, $zona = 'UTC')
    {
        if (!in_array($zona, timezone_identifiers_list())) {
            $zona = 'UTC';
        }

        $ahora = new DateTime("now", new DateTimeZone($zona));
        $expira = new DateTime($fecha, new DateTimeZone($zona));

        return $ahora > $expira;
    }

  public static function PaisGet()
    {
        return PaisModel::select("*")->get();
    }
}