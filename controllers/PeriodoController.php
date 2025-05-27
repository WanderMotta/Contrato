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

class PeriodoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PeriodoList[/{idperiodo}]", [PermissionMiddleware::class], "list.periodo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PeriodoAdd[/{idperiodo}]", [PermissionMiddleware::class], "add.periodo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PeriodoView[/{idperiodo}]", [PermissionMiddleware::class], "view.periodo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PeriodoEdit[/{idperiodo}]", [PermissionMiddleware::class], "edit.periodo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PeriodoDelete[/{idperiodo}]", [PermissionMiddleware::class], "delete.periodo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodoDelete");
    }
}
