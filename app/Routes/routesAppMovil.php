<?php
use Slim\App;
use App\Controllers\UserController;
use App\Controllers\Movil\ListasController;

return function (App $app)
{
   $app->group("/api",function($app)
     {
        $app->group("/Clientes",function($app)
        {
         $app->post("/Create",[UserController::class,'postClientes']);
         $app->post('/CadenaCliente',[UserController::class,'postCadenaCliente']); 
         $app->put("/Edit/{id}",[UserController::class,'putClientes']);
         $app->put('/EditOrdenaCliente/{Codcob}/{idzona}',[UserController::class,'putEditOrdenaCliente']);
        });

         $app->group("/Creditos",function($app)
         {
         $app->post('/Create',[UserController::class,'postCreate']);
         $app->post('/CreateFPro', [UserController::class,'postCreateFPro']);
         $app->post('/CreateProducto', [UserController::class,'postCreateProducto']);
         $app->post('/CreateSolicita',[UserController::class,'postCreateSolicita']);
         }); 

         $app->group("/Gastos",function($app)
         {
         $app->post("/Crear",[UserController::class,'postGastos']);
         $app->put("/EditGasto/{id}",[UserController::class,'putGastos']);
         $app->delete("/EliGasto/{id}",[UserController::class,'deleteGastos']);
         });

         $app->group("/Pagos",function($app)
         {
         $app->get("/Pagone/{Codcli}/{Codcob}",[UserController::class, 'getPagone']);
         $app->get("/Pagoall/{ciuda}/{Codcob}",[UserController::class,'getPagoall']);
         $app->get("/Pagonavega/{ciuda}/{Codcob}",[UserController::class, 'getPagonavega']);
         $app->get("/Pagohoy/{Codcob}",[UserController::class,'getPagohoy']);
         $app->get("/Numeropago/{idprest}",[UserController::class, 'getNumeropago']);
         $app->get("/PagoNavegacion/{Codcob}",[UserController::class,'getPagoNavegacion']);
         $app->get("/Cobroshoy/{Codcob}",[UserController::class, 'getCobroshoy']);
         $app->get("/PrimeraCuota/{Codcob}",[UserController::class,'getPrimeraCuota']);
         $app->get("/Micuotahoy/{Codcli}",[UserController::class, 'getMiCuotaHoy']);
         $app->get("/Miscuotashoy/{Codcli}",[UserController::class,'getMisCuotasHoy']);
         $app->post('/Pintas',[UserController::class,'postPuntosReferencias']);
         $app->post('/Novedad',[UserController::class,'postNovedad']);
         $app->post('/Enviar',[UserController::class,'postPagos']);
         $app->put('/EditNavegall/{Codcob}',[UserController::class,'putNavegall']);
         $app->put('/EditOrdenaRuta/{Codcob}',[UserController::class,'putEditOrdenaRuta']);
         }); 

         $app->group("/Busca",function($app)
         {
         $app->post("/Cliente",[ListasController::class,'postBuscaCliente']);
         $app->post("/ListaCliente",[ListasController::class,'postBuscaListaCliente']);
         });

         $app->group("/Lista",function($app)
         {
         $app->get("/Abonos/{Codcob}/{codCred}",[ListasController::class, 'getListaAbonos']);
         $app->get("/Ruta",[ListasController::class,'getListaRuta']);
         $app->get("/Cliente/{idcli}",[ListasController::class,'getListaCliente']);
         $app->get("/Frecuencia",[ListasController::class,'getListaFrecuencia']);
         $app->get("/Barrios/{ciuda}",[ListasController::class,'getListabarrios']);
         $app->get("/Gastos/{Codcob}",[ListasController::class,'getListaGastos']);
         $app->get("/Interes",[ListasController::class,'getListaInteres']);
         $app->get("/Tipogasto",[ListasController::class,'getListaTipoGasto']);
         $app->get("/Mercancia/{ciuda}",[ListasController::class,'getListaMercancia']);
         $app->get("/OrdenaRuta/{Codcob}",[ListasController::class,'getListaOrdenaRuta']);
         $app->get("/OrdenaCliente/{Codcob}/{Codzona}",[ListasController::class,'getListaOrdenaCliente']);
         $app->get("/Solicitud/{Codcli}",[ListasController::class,'getListaSolicitud']);
         $app->get("/Solicitudcredito/{Codcob}",[ListasController::class,'getListaSolicitudcredito']);
         $app->get("/Prodcompra/{Codcredito}",[ListasController::class,'getListaProdCompra']);
         $app->get("/Prodcompras/all",[ListasController::class,'getListaProdComprasAll']);
         $app->get("/Productos",[ListasController::class,'getListaProductos']);
         $app->get("/Pinta/{idcli}/{idcobra}",[ListasController::class,'getPuntoReferencia']);
         $app->get("/Pintas/{ciuda}/{Codcob}",[ListasController::class,'getPuntosReferencias']);
         $app->get("/LocalBarr/{idbarrio}",[ListasController::class,'getLocalBarrio']);
         $app->get("/Visitahoy/{Codcob}",[ListasController::class,'getVisitaHoy']);
         $app->get("/ProximaVisita/{Codcob}",[ListasController::class,'getProximaVisita']);
        });
   });
};
