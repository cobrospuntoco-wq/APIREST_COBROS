<?php

namespace App\Controllers\Mdn;

use App\Models\mdn\UsuarioModel;
use App\Models\mdn\UserRoll;
use App\Models\mdn\Userpermiso;
use App\Models\mdn\UserAcceso;
use App\Models\mdn\GT_user;

//use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;



class UserController
{

    protected $customResponse;

    protected $usuarioModel;

    protected $userRoll;

    protected $userPermiso;

    protected $userAcceso;

    protected $userGt;

    protected $validator;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
        $this->usuarioModel = new UsuarioModel();
        $this->userRoll = new UserRoll();
        $this->userPermiso = new Userpermiso();
        $this->userAcceso = new UserAcceso();
        $this->userGt = new GT_user();
    }

   public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

/* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA USER LOGIN */
    public function viewUser(Response $response)
    {
        $guestEntries = usuarioModel::select("ID_USER","ID_ROLL","USERNAME","ESTADO","AVATAR","FECHA")->get();
        return $this->customResponse->is200Response($response,$guestEntries); 
    }

    public function viewUserId(Response $response,$id)
    {
       $guestEntries = usuarioModel::select(
                       "ID_USER",
                       "ID_ROLL",
                       "USERNAME",
                       "ESTADO",
                       "AVATAR",
                       "FECHA")
                       
                    ->where("ID_USER","=",$id)
                    ->get();
        return $this->customResponse->is200Response($response,$guestEntries);
    }

    public function deleteUser(Response $response,$id)
    {
        $this->usuarioModel->where(["ID_USER"=>$id])->delete();
        $responseMessage = "El usuario fue eliminado exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function viewUserRoll(Response $response)
    {
        $guestEntriesroll = $this->userRoll->get();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }

      public function viewUserRollid(Response $response,$id)
    {
        $guestEntriesroll = $this->userRoll->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }


    public function createUsers(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "rol"=>v::notEmpty(),
           "users"=>v::notEmpty(),
           "password"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
        $guestEntry = new usuarioModel;
        $guestEntry->ID_ROLL     =   $data['rol'];
        $guestEntry->USERNAME    =   $data['users'];
        $guestEntry->ESTADO      =   1;
        $guestEntry->PASSWORD    =   $this->hashPassword($data['password']);
        $guestEntry->save();
        $responseMessage = array('msg' => "usuario Guardado correctamente",'id' => $guestEntry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

    public function editUsers(Request $request,Response $response,$id)
    {
         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
           "rol"=>v::notEmpty(),
           "users"=>v::notEmpty(),
           "estado"=>v::notEmpty()
         ]);
         
        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }
        try{
                $guestEntry = usuarioModel::find($id);
                $guestEntry->ID_ROLL     =   $data['rol'];
                $guestEntry->USERNAME    =   $data['users'];
                $guestEntry->ESTADO      =   1;
                $guestEntry->PASSWORD    =   $this->hashPassword($data['password']);
                $guestEntry->save();
                $responseMessage = array('msg' => "usuario Editado correctamente",'id' => $id);
                return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
                $responseMessage = array("err" => $err->getMessage());
                return $this->customResponse->is400Response($response,$responseMessage);
            }
    }
/* FIN DEL CRUE LOGIUN USER */
/* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA PERMISO */
    public function viewUserPermiso(Response $response)
    {
        $guestEntriespermiso = $this->userPermiso->get();
        return $this->customResponse->is200Response($response,$guestEntriespermiso);
    }

      public function viewUserPermisoid(Response $response,$id)
    {
        $guestEntriespermiso = $this->userPermiso->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestEntriespermiso);
    }

    public function createuserPermiso(Request $request,Response $response)
    {

    $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
           "IDUSERMENU"=>v::notEmpty(),
           "NOMBRE"=>v::notEmpty(),
           "ESTADO"=>v::notEmpty()
             ]); 
       	 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }
 try{
       
        $guestEntrypermiso = new Userpermiso;
        $guestEntrypermiso->ID_USER_MENU         =   $data['IDUSERMENU'];
        $guestEntrypermiso->NOMBRE               =   $data['NOMBRE'];
        $guestEntrypermiso->ESTADO               =   $data['ESTADO'];
        $guestEntrypermiso->save();
        $responseMessage = array('msg' => "permiso guardado correctamente",'id' => $guestEntrypermiso->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

   public function editUserPermiso(Request $request,Response $response,$id)
    {
        $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
              "IDUSERMENU"=>v::notEmpty(),
              "NOMBRE"=>v::notEmpty(),
              "ESTADO"=>v::notEmpty()
        ]); 
        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

     try{
        $guestEntrypermiso = Userpermiso::find($id);
        $guestEntrypermiso->ID_USER_MENU         =   $data['IDUSERMENU'];
        $guestEntrypermiso->NOMBRE               =   $data['NOMBRE'];
        $guestEntrypermiso->ESTADO               =   $data['ESTADO'];
        $guestEntrypermiso->save();
        $responseMessage = array('msg' => "permiso editado correctamente",'id' => $id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* FIN DEL CRUE PERMISO */
    /* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA ACCESOS */
 public function viewUserAcceso(Response $response)
    {
        $guestEntriesacceso = $this->userAcceso->get();
        return $this->customResponse->is200Response($response,$guestEntriesacceso);
    }

    public function viewUserAccesoid(Response $response,$id)
    {
        $guestEntriesacceso = $this->userAcceso->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestEntriesacceso);
    }

   public function createuserAcceso(Request $request,Response $response)
    {

         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "LAT"=>v::notEmpty(),
            "LON"=>v::notEmpty(),
            "CIUDAD"=>v::notEmpty(),
            "PAIS"=>v::notEmpty(),
            "IP"=>v::notEmpty()
          ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

    try{
        $Guestentryacceso = new UserAcceso;
        $Guestentryacceso->ID_USER         =   $data['IDUSER'];
        $Guestentryacceso->LAT             =   $data['LAT'];
        $Guestentryacceso->LON             =   $data['LON'];
        $Guestentryacceso->CIUDAD          =   $data['CIUDAD'];
        $Guestentryacceso->PAIS            =   $data['PAIS'];
        $Guestentryacceso->IP              =   $data['IP'];
        $Guestentryacceso->save();
        $responseMessage = array('msg' => "auditoria Guardada correctamente",'id' => $Guestentryacceso->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
    /* FIN DEL CRUE ACCESOS */
    /* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA GT_USER LA CUAL ES AUXILIAR */
    public function viewUserGt(Response $response)
    {
        $usergt_userentry = $this->userGt->get();
        return $this->customResponse->is200Response($response,$usergt_userentry);
    }

    public function viewUserGtid(Response $response,$id)
    {
        $guestgt_userentry = $this->userGt->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestgt_userentry);
    }

    public function createuserGt(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "IDTIPOUSER"=>v::notEmpty() 
       ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{
        $gtuserentry =  new GT_user; 
        $gtuserentry->ID_USER         =   $data['IDUSER'];
        $gtuserentry->ID_TIPO_USER    =   $data['IDTIPOUSER'];
        $gtuserentry->save();
        $responseMessage = array('msg' => "gt USUARIO guardado correctamente",'id' => $gtuserentry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editUserGt(Request $request,Response $response,$id)
    {
         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "IDTIPOUSER"=>v::notEmpty() 
          ]); 

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        try{
        $gtuserentry = GT_user::find($id);
        $gtuserentry->ID_USER         =   $data['IDUSER'];
        $gtuserentry->ID_TIPO_USER    =   $data['IDTIPOUSER'];
        $gtuserentry->save();
        $responseMessage = array('msg' => "gt USUARIO editado correctamente",'id' => $id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

}