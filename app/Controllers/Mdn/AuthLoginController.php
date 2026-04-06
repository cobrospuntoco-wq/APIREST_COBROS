<?php

namespace App\Controllers\Mdn;
use App\Models\mdn\LoginModel;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

class AuthLoginController
{
    protected $user;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->user = new LoginModel();
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
    $guestEntries = LoginModel::select(
         "tbl_user_login.ID_USER", 
         "tbl_user_login.ID_ROLL",
         "tbl_user_login.USERNAME",
         "tbl_user_login.NOMBRES",
         "tbl_user_login.ESTADO",
         "tbl_user_login.AVATAR",
         "tbl_user_roll.NOMBRE as USER_ROL"
         )->join(
                "tbl_user_roll", 
                "tbl_user_login.ID_ROLL","=","tbl_user_roll.ID")
            ->where("USERNAME","=",$users)
            ->first();
        return $guestEntries;
    }

 public function verifyAccount($users)
    {
        $count = $this->user->where(["USERNAME"=>$users])->count();
        var_dump($count);
        if($count==0)
        {
            return false;
        }

        return true;
    }

public function verifyAccountPass($password,$users)
    {
    $hashedPassword ="";

    $user = $this->user->where(["USERNAME"=>$users])->get();

         foreach ($user as $users)
        {
            $hashedPassword = $users->PASSWORD;
        }  

       // $hashedPassword = $user->PASSWORD;
         $verify = password_verify($password,$hashedPassword);
        if($verify==false)
        {
            return false;
        } 

        return true;
   /*  $user = $this->user->where("USERNAME", $users)->first();

                if (!$user) {
                    return false;
                }

                $hashedPassword = $user->pass;

                $verify = md5($password) === $hashedPassword;

                if (!$verify) {
                    return false;
                }

                return true; */
    }

}