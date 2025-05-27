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

class MovInsumoContratoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoList[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "list.mov_insumo_contrato")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoAdd[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "add.mov_insumo_contrato")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoView[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "view.mov_insumo_contrato")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoEdit[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "edit.mov_insumo_contrato")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MovInsumoContratoDelete[/{idmov_insumo_contrato}]", [PermissionMiddleware::class], "delete.mov_insumo_contrato")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/MovInsumoContratoPreview", [PermissionMiddleware::class], "preview.mov_insumo_contrato")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovInsumoContratoPreview", null, false);
    }
}
