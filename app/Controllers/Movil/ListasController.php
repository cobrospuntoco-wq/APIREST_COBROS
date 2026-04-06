<?php

namespace  App\Controllers\Movil;

use App\Models\cbr\PagosModel;
use App\Response\CustomResponse;
use Respect\Validation\Exceptions\Exception;
use App\Validation\Validator;
//use Respect\Validation\Validator as v;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListasController
{
protected $customResponse;
protected $validator;
protected $clientes;
protected $pagos;

   public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
        $this->pagos = new PagosModel();
    }
 public function getListaAbonos(Response $response, $codCred,$Codcob)
    {
        $GetPagos = $this->pagos
        ->where('cod_prest', $codCred)
        ->where('cod_cobrador', $Codcob)
        ->get();

$count = $GetPagos->count();
$datos = $GetPagos->map(function ($vector) use (&$count) {
                $count--;
                $fecha = \Carbon\Carbon::parse($vector->fecha_cuota);

                return [
                    'vlrcuota'  => number_format($vector->vlr_cuota),
                    'vlrsaldo'  => number_format($vector->vlr_saldo),
                    'fech_pago' => $fecha->format('d/m/Y'),
                    'hora'      => $fecha->format('H:i'),
                    'minnum'    => $count
                ];

            });

            $responseMessage = ['code'   => 100,'data' => $datos];
        return $this->customResponse->is200Response($response,$responseMessage);
    }
}