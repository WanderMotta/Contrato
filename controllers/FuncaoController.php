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

class FuncaoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/FuncaoList[/{idfuncao}]", [PermissionMiddleware::class], "list.funcao")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FuncaoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/FuncaoAdd[/{idfuncao}]", [PermissionMiddleware::class], "add.funcao")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FuncaoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/FuncaoView[/{idfuncao}]", [PermissionMiddleware::class], "view.funcao")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FuncaoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/FuncaoEdit[/{idfuncao}]", [PermissionMiddleware::class], "edit.funcao")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FuncaoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/FuncaoDelete[/{idfuncao}]", [PermissionMiddleware::class], "delete.funcao")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FuncaoDelete");
    }
}
