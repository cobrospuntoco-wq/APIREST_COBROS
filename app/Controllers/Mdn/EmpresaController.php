<?php

namespace App\Controllers\Mdn;
use Illuminate\Database\Capsule\Manager as Capsule;
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

        $respDBMessage =  crearBaseDatos($empresa_user_cnn, $empresa_pass_cnn, $empresa_db_cnn);

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

function crearBaseDatos($dbUser, $dbpass, $dbnombre)
{
     try {
        // 🔥 Sanitizar (MUY IMPORTANTE)
        $nombreBD = preg_replace('/[^a-zA-Z0-9_]/', '', $dbnombre);
        $UserDB   = preg_replace('/[^a-zA-Z0-9_]/', '', $dbUser);
        $PassDB   = preg_replace('/[^a-zA-Z0-9_]/', '', $dbpass);
        // 1. Crear base de datos
        Capsule::connection()->statement("
            CREATE DATABASE IF NOT EXISTS `$nombreBD`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
        ");

        // 2. Crear usuario
        Capsule::connection()->statement("
            CREATE USER IF NOT EXISTS '$UserDB'@'%' IDENTIFIED BY '$PassDB'
        ");

        // 3. Dar permisos SOLO a esa BD
        Capsule::connection()->statement("
            GRANT ALL PRIVILEGES ON `$nombreBD`.* TO '$UserDB'@'%'
        ");

        // 4. Aplicar cambios
        Capsule::connection()->statement("FLUSH PRIVILEGES");

        $respDBSql =  crearBaseDatos($UserDB, $PassDB, $nombreBD);

        return [
            "success" => true,
            "respArchivoSql" => $respDBSql,
            "message" => "BD y usuario creados correctamente"
        ];

    } catch (\Exception $e) {
        return [
            "success" => false,
            "message" => $e->getMessage()
        ];
    }
}

function ejecutarSQL($host, $dbUser, $dbpass, $dbnombre, $rutaArchivoSQL)
{
     try {
        $capsule = new Capsule;

        $nombreBD = preg_replace('/[^a-zA-Z0-9_]/', '', $dbnombre);
        $UserDB   = preg_replace('/[^a-zA-Z0-9_]/', '', $dbUser);
        $PassDB   = preg_replace('/[^a-zA-Z0-9_]/', '', $dbpass);

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $host,
            'database'  => $nombreBD,
            'username'  => $UserDB,
            'password'  => $PassDB,
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ], 'principal');

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $rutaSQL = __DIR__ . '/../../app/archivos/cobrosapp.sql';
        $sql = file_get_contents($rutaSQL);

        Capsule::connection('principal')->unprepared($sql);

        return [
            "success" => true,
            "message" => "Tablas creadas correctamente"
        ];

    } catch (\Exception $e) {
        return [
            "success" => false,
            "message" => $e->getMessage()
        ];
    }
}