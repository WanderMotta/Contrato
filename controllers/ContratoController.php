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

class ContratoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ContratoList[/{idcontrato}]", [PermissionMiddleware::class], "list.contrato")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContratoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ContratoAdd[/{idcontrato}]", [PermissionMiddleware::class], "add.contrato")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContratoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ContratoView[/{idcontrato}]", [PermissionMiddleware::class], "view.contrato")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContratoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ContratoEdit[/{idcontrato}]", [PermissionMiddleware::class], "edit.contrato")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContratoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ContratoDelete[/{idcontrato}]", [PermissionMiddleware::class], "delete.contrato")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContratoDelete");
    }
}
