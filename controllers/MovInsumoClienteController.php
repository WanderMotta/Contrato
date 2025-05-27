<?php

namespace PHPMaker2024\contratos;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\contratos\Attributes\Delete;
use PHPMaker2024\contratos\Attributes\Get;
use PHPMaker2024\contratos\Attributes\Map;
use PHPMaker2024\contratos\Attributes\Options;
use PHPMaker2024\contratos\Attributes\Patch;
use PHPMaker2024\contratos\Attributes\Post;
use PHPMaker2024\contratos\Attributes\Put;

class MovInsumoClienteController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoClienteList[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "list.mov_insumo_cliente")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClienteList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoClienteAdd[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "add.mov_insumo_cliente")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClienteAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoClienteView[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "view.mov_insumo_cliente")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClienteView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoClienteEdit[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "edit.mov_insumo_cliente")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClienteEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoClienteDelete[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "delete.mov_insumo_cliente")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClienteDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/MovInsumoClientePreview", [PermissionMiddleware::class], "preview.mov_insumo_cliente")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoClientePreview", null, false);
    }
}
