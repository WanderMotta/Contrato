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

class ItensModuloController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ItensModuloList[/{iditens_modulo}]", [PermissionMiddleware::class], "list.itens_modulo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ItensModuloAdd[/{iditens_modulo}]", [PermissionMiddleware::class], "add.itens_modulo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ItensModuloView[/{iditens_modulo}]", [PermissionMiddleware::class], "view.itens_modulo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ItensModuloEdit[/{iditens_modulo}]", [PermissionMiddleware::class], "edit.itens_modulo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ItensModuloDelete[/{iditens_modulo}]", [PermissionMiddleware::class], "delete.itens_modulo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ItensModuloPreview", [PermissionMiddleware::class], "preview.itens_modulo")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItensModuloPreview", null, false);
    }
}
