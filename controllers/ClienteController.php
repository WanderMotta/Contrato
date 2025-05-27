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

class ClienteController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ClienteList[/{idcliente}]", [PermissionMiddleware::class], "list.cliente")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClienteList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ClienteAdd[/{idcliente}]", [PermissionMiddleware::class], "add.cliente")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClienteAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ClienteView[/{idcliente}]", [PermissionMiddleware::class], "view.cliente")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClienteView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ClienteEdit[/{idcliente}]", [PermissionMiddleware::class], "edit.cliente")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClienteEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ClienteDelete[/{idcliente}]", [PermissionMiddleware::class], "delete.cliente")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ClienteDelete");
    }
}
