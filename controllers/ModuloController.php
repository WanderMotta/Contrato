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

class ModuloController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ModuloList[/{idmodulo}]", [PermissionMiddleware::class], "list.modulo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ModuloList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ModuloView[/{idmodulo}]", [PermissionMiddleware::class], "view.modulo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ModuloView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ModuloEdit[/{idmodulo}]", [PermissionMiddleware::class], "edit.modulo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ModuloEdit");
    }
}
