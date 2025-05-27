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

class CargoCopyController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CargoCopyList[/{idcargo}]", [PermissionMiddleware::class], "list.cargo_copy")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoCopyList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CargoCopyAdd[/{idcargo}]", [PermissionMiddleware::class], "add.cargo_copy")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoCopyAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CargoCopyView[/{idcargo}]", [PermissionMiddleware::class], "view.cargo_copy")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoCopyView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CargoCopyEdit[/{idcargo}]", [PermissionMiddleware::class], "edit.cargo_copy")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoCopyEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CargoCopyDelete[/{idcargo}]", [PermissionMiddleware::class], "delete.cargo_copy")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoCopyDelete");
    }
}
