<?php
use Slim\App;
use App\Controllers\UserController;

return function (App $app)
{
   $app->group("/api",function($app)
     {

      $app->group("/empleados",function($app)
      {
         $app->post("/crear",[UserController::class,'postCrearEmpleados']);
         $app->put("/editar/{id}",[UserController::class,'putEmpleados']);
         $app->put("/editarestado/{id}",[UserController::class,'putEstadoEmpleados']);
      });

      $app->group("/clientes",function($app)
      {
         $app->post("/crear",[UserController::class,'postCrearClientes']);
         $app->put("/editar/{id}",[UserController::class,'putCrearClientes']);
         $app->delete("/eliminar/{id}",[UserController::class,'deleteClientes']);
         $app->delete("/eliminadoclinoasig/{id}",[UserController::class,'deleteClienteNoAsig']);
      });

      $app->group("/creditos",function($app)
      {
         $app->post("/crear",[UserController::class,'postCrearCreditos']);
         $app->put("/editar/{id}",[UserController::class,'putCrearCreditos']);
         $app->delete("/eliminar/{id}",[UserController::class,'deleteCrearCreditos']);
      }); 

      $app->group("/pagos",function($app)
      {
         $app->post("/crear",[UserController::class,'postCrearPagos']);
         $app->put("/editar/{id}",[UserController::class,'putCrearPagos']);
         $app->delete("/eliminar/{id}",[UserController::class,'deletePagos']);
      });

      $app->group("/recaudos",function($app)
      {
         $app->post("/crear",[UserController::class,'postCrearRecaudos']);
         $app->put("/editar/{id}",[UserController::class,'putCrearRecaudos']);
         $app->delete("/eliminar/{id}",[UserController::class,'deleteRecaudos']);
      });

       $app->group("/inversiones",function($app)
      {
         $app->post("/crearinicial",[UserController::class,'postCrearInversionInicial']);
         $app->post("/crearcapital",[UserController::class,'postCrearInversionCapital']);
         $app->put("/editarinicial/{id}",[UserController::class,'putCrearInversionInicial']);
         $app->put("/editarcapital/{id}",[UserController::class,'putCrearInversionCapital']);
         $app->delete("/eliminarinicial/{id}",[UserController::class,'deleteInversionInicial']);
         $app->delete("/eliminarcapital/{id}",[UserController::class,'deleteInversionCapital']);
      });

      $app->group("/gastos",function($app)
      {
         $app->post("/crearOperativos",[UserController::class,'postCrearGastosOperativos']);
         $app->post("/crearGenerales",[UserController::class,'postCrearGastosGenerales']);
         $app->put("/editarGenerales/{id}",[UserController::class,'putCrearGastosGenerales']);
         $app->put("/editarOperativos/{id}",[UserController::class,'putCrearGastosOperativos']);
         $app->delete("/eliminar/{id}",[UserController::class,'deleteGastos']);
      });

      $app->group("/listarahora",function($app)
      {
         $app->get("/clientehoy",[UserController::class, 'getClihoy']);
         $app->get("/nuevocredito",[UserController::class,'getNuevoCredito']);
         $app->put("/recaudocartera",[UserController::class,'getRecaudoCartera']);
         $app->get("/recaudoempleado",[UserController::class,'getRecaudoEmpleado']);
         $app->get("/recaudomap",[UserController::class,'getRecaudoMap']);
         $app->get("/recaudopago",[UserController::class,'getRecaudoPago']);
      });

      $app->group("/listadashboard",function($app)
      {
         $app->get("/cobradorinfoini",[UserController::class,'getCobradorInfoIni']);
         $app->get("/infoinizonacliente",[UserController::class,'getInfoIniZonaCliente']);
         $app->get("/retornainfotcp",[UserController::class,'getRetornaInfoTCP']);
         $app->get("/retornainfofcb",[UserController::class,'getRetornaInfoFCB']);
         $app->get("/detalleshowpagoshoy",[UserController::class,'getDetalleShowPagosHoy']);
         $app->get("/detalleshowcreditoshoy",[UserController::class,'getDetalleShowCreditosHoy']);
         $app->get("/detalleshowclienteshoy",[UserController::class,'getDetalleShowClientesHoy']);
         $app->get("/detalleshowcreditos",[UserController::class,'getDetalleShowCreditos']);
         $app->get("/showprestpend",[UserController::class,'getShowPrestamosPendientes']);
         $app->get("/detalleshowprestpend",[UserController::class,'getDetalleShowPrestamosPendientes']);
         $app->get("/showpagosatraso",[UserController::class,'getShowPagosAtraso']);
         $app->get("/lstshowpagosatraso",[UserController::class,'getLstShowPagosAtraso']);
         $app->get("/lstarticulo",[UserController::class,'getLstArticulo']);
      });

      $app->group("/graficasdashboard",function($app)
      {
         $app->get("/recorridodiario",[UserController::class,'getRecorridoDiario']);
         $app->get("/clientescreditos",[UserController::class,'getClientesCreditos']);
         $app->get("/estadocreditos",[UserController::class,'getEstadoCreditos']);
         $app->get("/estadorutas",[UserController::class,'getEstadoRutas']);
         $app->get("/recorridocartera",[UserController::class,'getRecorridoCartera']);
         $app->get("/rptutilidad",[UserController::class,'getRptUtilidad']);
      });
       $app->group("/listaradmin",function($app)
      {
         $app->get("/recorridodiario",[UserController::class,'getRecorridoDiario']);
         /* $app->get("/clientescreditos",[UserController::class,'getClientesCreditos']);
         $app->get("/estadocreditos",[UserController::class,'getEstadoCreditos']);
         $app->get("/estadorutas",[UserController::class,'getEstadoRutas']);
         $app->get("/recorridocartera",[UserController::class,'getRecorridoCartera']);
         $app->get("/rptutilidad",[UserController::class,'getRptUtilidad']); */
      });

       $app->group("/reportes",function($app)
      {
         $app->get("/reporteclientes",[UserController::class,'getReporteClientes']);
         $app->get("/reportecreditos",[UserController::class,'getReporteCreditos']);
         $app->get("/reportepagos",[UserController::class,'getReportePagos']);
         $app->get("/reportegastos",[UserController::class,'getReporteGastos']);
         $app->get("/reporteinversiones",[UserController::class,'getReporteInversiones']);
      });
      
   });
};