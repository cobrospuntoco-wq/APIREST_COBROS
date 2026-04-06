<?php

namespace  App\Controllers\cbr;

use App\Models\ClientesEntry;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ClienteController
{
    protected $customResponse;
    protected $validator;
    protected $clientePlanesEntry;
    protected $clienteEntry;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
        $this->clienteEntry = new ClientesEntry();
    }
    /* INICIO PROCESO TABLA CLIENTE PLANES */
 public function viewClientesGet(Response $response)
    {
        $ClientesGet = $this->clientePlanesEntry->get();
        return $this->customResponse->is200Response($response,$ClientesGet);
    }

    public function viewClientesGetid(Response $response,$id)
    {
        $ClientesGet = $this->clientePlanesEntry->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$ClientesGet);
    }

    public function deleteClientes(Response $response,$id)
    {
        $this->clientePlanesEntry->where(["ID"=>$id])->delete();
        $responseMessage = "El plan del Cliente fue eliminado exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createClientesEntry(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
            	"Codclientes"=>v::notEmpty(),
                "Tipoplanes"=>v::notEmpty(),
             ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{

                $ClientesEntry = new ClientesEntry();
                $ClientesEntry->cod_clientes   = $data['Codclientes'];
                $ClientesEntry->tipo_planes    = $data['Tipoplanes'];
                $ClientesEntry->save();

        $responseMessage = array('msg' 
        => "el plan Cliente guardado correctamente",'id' 
        => $ClientesEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){

        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);

       }
    }

    public function editaClientesEntry(Request $request,Response $response,$id)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
                "Codclientes"=>v::notEmpty(),
                "Tipoplanes"=>v::notEmpty(),
        ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{

               $ClientesEntry = ClientesEntry::find($id);
               $ClientesEntry->cod_clientes   = $data['Codclientes'];
               $ClientesEntry->tipo_planes    = $data['Tipoplanes'];
               $ClientesEntry->save();

        $responseMessage = array('msg' 
        => "Cliente editado correctamente",'id' 
        => $ClientesEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){

        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);

       }
    }
}