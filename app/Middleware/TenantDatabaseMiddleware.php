<?php
namespace App\Middleware;

use App\Models\mdn\EmpresaModel;
use App\Services\DatabaseManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TenantDatabaseMiddleware
{
    public function __invoke($request, RequestHandlerInterface $handler): ResponseInterface
    {

    $path = $request->getUri()->getPath();
        // ✅ BYPASS: rutas sin tenant (login principal)
        if (str_contains($path, '/api/mdn/')) {
                return $handler->handle($request);
        }

        $empresaId = $request->getHeaderLine('X-Empresa');
       // var_dump($empresaId);
        if (!$empresaId) {
            throw new \Exception("Empresa no enviada");
        }

        $empresa = EmpresaModel::find($empresaId);

        if (!$empresa) {
            throw new \Exception("Empresa no encontrada");
        }

        DatabaseManager::conectarCliente($empresa);

        return $handler->handle($request);
    }
}