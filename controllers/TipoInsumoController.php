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

class TipoInsumoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoInsumoList[/{idtipo_insumo}]", [PermissionMiddleware::class], "list.tipo_insumo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoInsumoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoInsumoAdd[/{idtipo_insumo}]", [PermissionMiddleware::class], "add.tipo_insumo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoInsumoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoInsumoView[/{idtipo_insumo}]", [PermissionMiddleware::class], "view.tipo_insumo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoInsumoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoInsumoEdit[/{idtipo_insumo}]", [PermissionMiddleware::class], "edit.tipo_insumo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoInsumoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoInsumoDelete[/{idtipo_insumo}]", [PermissionMiddleware::class], "delete.tipo_insumo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoInsumoDelete");
    }
}
