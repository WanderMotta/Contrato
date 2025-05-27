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

class TipoUniformeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoUniformeList[/{idtipo_uniforme}]", [PermissionMiddleware::class], "list.tipo_uniforme")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoUniformeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoUniformeAdd[/{idtipo_uniforme}]", [PermissionMiddleware::class], "add.tipo_uniforme")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoUniformeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoUniformeView[/{idtipo_uniforme}]", [PermissionMiddleware::class], "view.tipo_uniforme")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoUniformeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoUniformeEdit[/{idtipo_uniforme}]", [PermissionMiddleware::class], "edit.tipo_uniforme")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoUniformeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoUniformeDelete[/{idtipo_uniforme}]", [PermissionMiddleware::class], "delete.tipo_uniforme")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoUniformeDelete");
    }
}
