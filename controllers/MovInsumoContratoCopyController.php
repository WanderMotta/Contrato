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

class MovInsumoContratoCopyController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoCopyList[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "list.mov_insumo_contrato_copy")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoCopyList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoCopyAdd[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "add.mov_insumo_contrato_copy")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoCopyAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoCopyView[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "view.mov_insumo_contrato_copy")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoCopyView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoCopyEdit[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "edit.mov_insumo_contrato_copy")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoCopyEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoCopyDelete[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "delete.mov_insumo_contrato_copy")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoCopyDelete");
    }
}
