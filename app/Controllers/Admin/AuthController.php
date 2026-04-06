<?php
namespace App\Controllers\Admin;

use App\Models\cbr\UsuarioModel;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

class AuthController
{

    protected $user;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->user = new UsuarioModel();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }
    public function Login(Request $request,Response $response)
    {
        $this->validator->validate($request,[
            "email"=>v::notEmpty(),
            "password"=>v::notEmpty()
        ]);

    if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $responseUser = $this->verifyUser(
            CustomRequestHandler::getParam($request,"email")
        );

        $verifyAccount = $this->verifyAccount(
            CustomRequestHandler::getParam($request,"email")
        );


         $verifyAccountPass = $this->verifyAccountPass(
            CustomRequestHandler::getParam($request,"password"),
            CustomRequestHandler::getParam($request,"email")
        ); 

        if($verifyAccount==false)
        {
            $responseMessage = "invalid username";
            return $this->customResponse->is400Response($response,$responseMessage);
        } 

       if($verifyAccountPass==false)
        {
            $responseMessage = "invalid password";
            return $this->customResponse->is400Response($response,$responseMessage);
        } 
        
        $responseToken = \App\Controllers\GenerateTokenController::generateToken(
                        CustomRequestHandler::getParam($request,"email")
        );
        
         $responseMessage = array(
             'access_token' => $responseToken, 
             'access_data' => $responseUser
            );
        return $this->customResponse->is200Response($response,$responseMessage);
    }

 public function verifyUser($users)
    {
    $guestEntries = UsuarioModel::select("ID","usuario","pass")
            ->where("usuario","=",$users)
            ->first();
        return $guestEntries;
    }

 public function verifyAccount($users)
    {
        $count = $this->user->where(["usuario"=>$users])->count();
        var_dump($count);
        if($count==0)
        {
            return false;
        }

        return true;
    }

public function verifyAccountPass($password,$users)
    {

    $user = $this->user->where("usuario", $users)->first();

                if (!$user) {
                    return false;
                }

                $hashedPassword = $user->pass;

                $verify = md5($password) === $hashedPassword;

                if (!$verify) {
                    return false;
                }

                return true;
    }
}