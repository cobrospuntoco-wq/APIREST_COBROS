<?php

use Slim\App;
use App\Controllers\Admin\AuthController;
//use App\Controllers\UserController;

return function (App $app)
{
   $app->group("/api",function($app)
     {

        $app->group("/auth",function($app)
        {
            $app->post("/login",[AuthController::class,"Login"]);
        });

        $app->group("/usuarios",function($app)
         {
         /* $app->get("/listar",[UserController::class, 'getUsuarios']);
         $app->get("/listar/{id}",[UserController::class,'getUsuarioId']);
         $app->get("/listarbuscar/{buscauser}",[UserController::class,'getUsuarioBuscauser']);
         $app->post("/crear",[UserController::class,'postCreateUsuarios']);
         $app->put("/editar/{id}",[UserController::class,'putEditarUsuarios']);
         $app->put("/editarestado/{id}",[UserController::class,'putEditarEstadoUsuarios']);
         $app->put("/editarpass/{id}",[UserController::class,'putEditarPassUsuarios']);
         $app->get("/listarusuarioroll",[UserController::class,'getUsuarioRoll']);
         $app->get("/listarusuarioroll/{id}",[UserController::class,'getUsuarioRollid']);
         $app->get("/listauserioacceso",[UserController::class,'getUsuarioAcceso']);
         $app->get("/listaruseracceso/{id}",[UserController::class,'getUsuarioAccesoid']);
         $app->post("/createusuarioacceso",[UserController::class,'postCreateUsuarioAcceso']); */
       });
   });
};
