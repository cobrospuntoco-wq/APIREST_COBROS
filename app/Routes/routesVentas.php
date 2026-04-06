<?php
use Slim\App;
/* use App\Controllers\UserController; */

return function (App $app)
{
   $app->group("/api",function($app)
     {
        $app->group("/ventas",function($app)
         {
         /* $app->get("/view-user",[UserController::class, 'viewUser']);
         $app->get("/view-user/{id}",[UserController::class,'viewUserId']);
         $app->post("/create-user",[UserController::class,'createUsers']);
         $app->put("/edit-user/{id}",[UserController::class,'editUsers']);

         $app->get("/view-user-acceso",[UserController::class,'viewUserAcceso']);
         $app->get("/view-user-acceso/{id}",[UserController::class,'viewUserAccesoid']);
         $app->post("/create-user-acceso",[UserController::class,'createuserAcceso']); */
       }); 
   });
};