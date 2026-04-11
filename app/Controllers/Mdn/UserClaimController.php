<?php

namespace App\Controllers\Mdn;
use App\Models\mdn\UsuarioClaimModel;
use App\Models\mdn\EmpresaModel;
use App\Services\MailService;
use App\Helpers\DataTimeZona;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

class UserClaimController
{
    protected $usuarioClaim;
    protected $empresa;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->usuarioClaim = new UsuarioClaimModel();
        $this->empresa = new EmpresaModel();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }
    /* INICIO PROCESO TABLA CLAIM USURIOS */
 public function viewClaimGet(Response $response)
    {
        $ClaimGet = $this->usuarioClaim->get();
        return $this->customResponse->is200Response($response,$ClaimGet);
    }

    public function viewClaimGetId(Response $response,$id)
    {
        $ClientesGet = $this->usuarioClaim->where(["id"=>$id])->get();
        return $this->customResponse->is200Response($response,$ClientesGet);
    }

    public function usuarioClaimPost(Request $request,Response $response)
    {
         $data = json_decode($request->getBody(),true); 
         $UsuarioClaim = $this->usuarioClaim
                        ->from('claims_cobros as c')
                        ->join(
                            'clientes_cobros as e',
                            'e.id_int','=','c.id_empresa'
                        )->join(
                            'tbl_paises as p',
                            'p.id','=','c.id_pais' // 👈 ajusta este campo según tu BD
                        )->where(function ($q) use ($data) {
                            $q->where('c.email', $data['param'])
                            ->orWhere('c.usuario', $data['param']);
                        })->select(
                            'c.id',
                            'c.id_empresa',
                            'c.id_pais',
                            'c.email',
                            'c.usuario',
                            'e.nombre_cliente as empresa_nombre',
                            'e.valida_pgo',
                            'e.valida_whatsapp',
                            'e.valida_sms',
                            'e.operacia as valida_operacion',
                            'p.nombre as pais',
                            'p.iso2 as codigo_pais',
                            'p.phone_code as codigo_pais_telefono',
                            'p.timezone as codigo_pais_timezone',
                        )
                        ->first();
        return $this->customResponse->is200Response($response,$UsuarioClaim);
    }

    public function deleteClaim(Response $response,$id)
    {
        $this->usuarioClaim->where(["id"=>$id])->delete();
        $responseMessage = "El  Usuario claim fue eliminado exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function createClaimPost(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
            	"Id_Empresa"=>v::notEmpty(),
                "Id_Pais"=>v::notEmpty(),
                "Usuario"=>v::notEmpty(),
                "Email"=>v::notEmpty(),
                "NombreRol"=>v::notEmpty()
             ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{

                $ClaimUser = new UsuarioClaimModel();
                $ClaimUser->id_empresa   = $data['Id_Empresa'];
                $ClaimUser->id_pais      = $data['Id_Pais'];
                $ClaimUser->usuario      = $data['Usuario'];
                $ClaimUser->email        = $data['Email'];
                $ClaimUser->rol          = $data['NombreRol'];
                $ClaimUser->estado       = '1';
                $ClaimUser->save();

        $responseMessage = array('msg' 
        => "El Claim guardado correctamente",'id' => $ClaimUser->id_claim);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){

        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);

       }
    }

    public function editaClaimPost(Request $request,Response $response,$id)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
            	"Id_Empresa"=>v::notEmpty(),
                "Id_Pais"=>v::notEmpty(),
                "Usuario"=>v::notEmpty(),
                "Email"=>v::notEmpty(),
                "Estado"=>v::notEmpty(),
                "NombreRol"=>v::notEmpty()
             ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{

                $ClaimUser = UsuarioClaimModel::find($id);
                $ClaimUser->id_empresa   = $data['Id_Empresa'];
                $ClaimUser->id_pais      = $data['Id_Pais'];
                $ClaimUser->usuario      = $data['Usuario'];
                $ClaimUser->email        = $data['Email'];
                $ClaimUser->rol          = $data['NombreRol'];
                $ClaimUser->estado       = $data['Estado'];
                $ClaimUser->save();

        $responseMessage = array('msg' 
        => "Claim editado correctamente",'id' 
        => $ClaimUser->id_claim);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){

        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);

       }
    }

    public function codigoFactorClaimPut(Request $request,Response $response,$id)
    {
       $data = json_decode($request->getBody(), true);

            // 🔹 Validación
           $this->validator->validate($request, [
                 "Claim_user_id" => v::notEmpty(),
                 "Claim_pais_id" => v::notEmpty()
            ]);

            if ($this->validator->failed()) {
                return $this->customResponse->is400Response(
                    $response,
                    $this->validator->errors
                );
            }

            // 🔥 obtener ID correctamente
           //  $claimUser = $data['Claim_user_id'];
            // $Pais_id = PaisGetId($data['Claim_pais_id']);
            // ⏳ expiración
          //   $zonaHoraria = !empty($PaisFactor->timezone) ? $PaisFactor->timezone : 'UTC';
             $fechaExpira = DataTimeZona::generarFechaExpira($data['Claim_pais_id']);

            // 🔐 generar código
            $codigoFactor = generarCodigo2FA();
            try {
                // 🔹 buscar usuario
                $usuarioFactor = UsuarioClaimModel::find($id);
                if (!$usuarioFactor) {
                    return $this->customResponse->is400Response($response, [
                        "error" => "Usuario claim no encontrado"
                    ]);
                }

                // 🔥 guardar código + expiración
                $usuarioFactor->codigo_2dofactor = generarCodigo2FA();
                $usuarioFactor->expiracion_factor = $fechaExpira;
                $usuarioFactor->save();

                // 📧 enviar correo con SendGrid
                $mailService = new MailService();
                $status = $mailService->enviarCodigo2FA($usuarioFactor->email, $codigoFactor);

              /*   if ($status != 202) {
                    return $this->customResponse->is400Response($response, [
                        "error" => "Error enviando correo",
                        "detalle" => $status
                    ]);
                } */

                // ✅ respuesta
                return $this->customResponse->is200Response($response, [
                    "msg" => "Código de doble factor enviado correctamente",
                    "usuario_id" => $usuarioFactor->id
                ]);

            } catch (\Exception $err) {

                return $this->customResponse->is400Response($response, [
                    "error" => $err->getMessage()
                ]);
            }
    }

  public function validarFactorClaimPost(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);

        $this->validator->validate($request,[
            	"Codigo2FA"=>v::notEmpty()
             ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }
      try {
                $claimUser = UsuarioClaimModel::where('codigo_2dofactor', $data['Codigo2FA'])
                    ->where('expiracion_factor', '<', date('Y-m-d H:i:s'))
                    ->first();

                if (!$claimUser) {
                    return $this->customResponse->is400Response($response, [
                        "msg" => "Código inválido o expirado"
                    ]);
                }

                 // Limpiar código (importante)
                $claimUser->codigo_2dofactor = 0;
                $claimUser->expiracion_factor = null;
                $claimUser->save();

                // ✅ código válido
                return $this->customResponse->is200Response($response, [
                    "usuario_id" => $claimUser->id
                ]);
       } catch (\Exception $err) {

                return $this->customResponse->is400Response($response, [
                    "error" => $err->getMessage()
                ]);
            }
   }

}

function generarCodigo2FA($length = 6)
{
    return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

