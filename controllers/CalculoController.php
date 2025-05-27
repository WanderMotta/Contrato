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

class CalculoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CalculoList[/{idcalculo}]", [PermissionMiddleware::class], "list.calculo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalculoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CalculoAdd[/{idcalculo}]", [PermissionMiddleware::class], "add.calculo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalculoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CalculoView[/{idcalculo}]", [PermissionMiddleware::class], "view.calculo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalculoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CalculoEdit[/{idcalculo}]", [PermissionMiddleware::class], "edit.calculo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalculoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CalculoDelete[/{idcalculo}]", [PermissionMiddleware::class], "delete.calculo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalculoDelete");
    }
}
