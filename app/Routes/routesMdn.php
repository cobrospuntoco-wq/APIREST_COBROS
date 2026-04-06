<?php
use Slim\App;
use App\Controllers\Mdn\AuthLoginController;
use App\Controllers\Mdn\UserController;
use App\Controllers\Mdn\UserClaimController;
use App\Controllers\Mdn\EmpresaController;

return function (App $app)
{
   $app->group("/api/mdn",function($app)
     {
        $app->group("/auth",function($app)
        {
            $app->post("/login",[AuthLoginController::class,"Login"]);
        });

        $app->group("/users",function($app)
         {
         $app->get("/view-user",[UserController::class, 'viewUser']);
         $app->get("/view-user/{id}",[UserController::class,'viewUserId']);
         $app->post("/create-user",[UserController::class,'createUsers']);
         $app->put("/edit-user/{id}",[UserController::class,'editUsers']);

         $app->get("/view-user-roll",[UserController::class,'viewUserRoll']);
         $app->get("/view-user-roll/{id}",[UserController::class,'viewUserRollid']);

         $app->get("/view-user-permiso",[UserController::class,'viewUserPermiso']);
         $app->get("/view-user-permiso/{id}",[UserController::class,'viewUserPermisoid']);
         $app->post("/create-user-permiso",[UserController::class,'createuserPermiso']);
         $app->put("/edit-user-permiso/{id}",[UserController::class,'editUserPermiso']);

         $app->get("/view-user-acceso",[UserController::class,'viewUserAcceso']);
         $app->get("/view-user-acceso/{id}",[UserController::class,'viewUserAccesoid']);
         $app->post("/create-user-acceso",[UserController::class,'createuserAcceso']);
           
         $app->post("/create-user-gt",[UserController::class,'createuserGt']);
         $app->put("/edit-user-gt/{id}",[UserController::class,'editUserGt']);
       });

         $app->group("/empresa",function($app)
         {
         $app->get("/view-empresa",[EmpresaController::class, 'viewEmpresaGet']);
         $app->get("/view-empresa/{id}",[EmpresaController::class,'viewEmpresaGetId']);
         $app->post("/create-empresa",[EmpresaController::class,'createEmpresa']);
         $app->put("/edit-empresa/{id}",[EmpresaController::class,'editEmpresa']);
         $app->put("/editestado-empresa/{id}",[EmpresaController::class,'updateEstadoPago']);
         $app->delete("/delet-empresa/{id}",[EmpresaController::class,'deletEmpresa']);
      });

         $app->group("/claim",function($app)
         {
         $app->get("/view-claim",[UserClaimController::class, 'viewClaimGet']);
         $app->get("/view-claim/{id}",[UserClaimController::class,'viewClaimGetId']);
         $app->post("/usuario-claim",[UserClaimController::class,'usuarioClaimPost']);
         $app->post("/create-claim",[UserClaimController::class,'createClaimPost']);
         $app->put("/edit-claim/{id}",[UserClaimController::class,'editaClaimPost']);
         $app->patch("/editcodigo-factorclaim/{id}",[UserClaimController::class,'codigoFactorClaimPut']);
         $app->post("/valida-factorclaim",[UserClaimController::class,'validarFactorClaimPost']);
         $app->delete("/delet-claim/{id}",[UserClaimController::class,'deleteClaim']);
      });

      $app->group("/catalogo",function($app)
         {
         $app->get("/view-pais",[EmpresaController::class, 'viewPaisGet']);
         $app->get("/view-pais/{id}",[EmpresaController::class, 'viewPaisGetId']);
         $app->get("/view-ciudad",[EmpresaController::class, 'viewCiudadGet']);
      });
   });
};