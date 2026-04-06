<?php

namespace App\Controllers\Mdn;
use App\Models\mdn\EmpresaModel;
use App\Models\mdn\PaisModel;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

class EmpresaController
{
    protected $empresa;
    protected $pais;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->empresa = new EmpresaModel();
        $this->pais = new  PaisModel();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }
    public function viewEmpresaGet(Response $response)
    {
        $ClaimGet = $this->empresa->get();
        return $this->customResponse->is200Response($response,$ClaimGet);
    }

    public function viewEmpresaGetId(Response $response,$id)
    {
        $ClientesGet = $this->empresa->where(["id_int"=>$id])->get();
        return $this->customResponse->is200Response($response,$ClientesGet);
    }

    public function deletEmpresa(Response $response,$id)
    {
        $this->empresa->where(["id_int"=>$id])->delete();
        $responseMessage = "La empresa fue eliminada exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

        public function createEmpresaPost(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
            	"NomEmpresa"       =>v::notEmpty(),
                "Id_Pais"          =>v::notEmpty(),
                'Telefono_Cliente' =>v::notEmpty(),
                'Pref_Tel_Cliente' =>v::notEmpty(),
                'Cantida_Cliente'  =>v::notEmpty()
             ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

        $cadenapass = generarCadena();
        
        $empresa_db_cnn = 'cobrosco_'.trim($data['NomEmpresa']);
        $empresa_user_cnn = 'cobrosco_user_'.trim($data['NomEmpresa']);
        $empresa_pass_cnn = 'cobrosco_'.generarCadena();
       try{

                $empresa = new EmpresaModel();
                $empresa->bd_cnn              = $empresa_db_cnn;
                $empresa->user_cnn            = $empresa_user_cnn;
                $empresa->pss_cnn             = $empresa_pass_cnn;
                $empresa->nombre_cliente      = $data['NomEmpresa'];
                $empresa->nombre_cliente_cnn  = trim($data['NomEmpresa']); 
                $empresa->id_pais             = $data['Id_Pais'];
                $empresa->telefono_cliente    = $data['Telefono_Cliente'];
                $empresa->prefijo_tel_cliente = $data['Pref_Tel_Cliente'];
                $empresa->cantida_cli         = $data['Cantida_Cliente'];
                $empresa->valida_pgo          = 1;
                $empresa->valida_whatsapp     = 0;
                $empresa->valida_sms          = 0;
                $empresa->operacia            = 1;
                $empresa->save();

        $responseMessage = array('msg' 
        => "El Claim guardado correctamente",'id' 
        => $empresa->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){

        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);

       }
    }

    public function viewPaisGet(Response $response)
    {
        $ClaimGet = $this->pais->get();
        return $this->customResponse->is200Response($response,$ClaimGet);
    }
    
    public function viewPaisGetId(Response $response,$id)
    {
        $ClaimGet = $this->pais->where(["id"=>$id])->get();
        return $this->customResponse->is200Response($response,$ClaimGet);
    }
}

function generarCadena() {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $cadena = '';
    
    for ($i = 0; $i < 5; $i++) {
        $cadena .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $cadena;
   }