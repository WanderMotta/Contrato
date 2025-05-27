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

class FaturamentoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/FaturamentoList[/{idfaturamento}]", [PermissionMiddleware::class], "list.faturamento")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/FaturamentoAdd[/{idfaturamento}]", [PermissionMiddleware::class], "add.faturamento")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/FaturamentoView[/{idfaturamento}]", [PermissionMiddleware::class], "view.faturamento")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/FaturamentoEdit[/{idfaturamento}]", [PermissionMiddleware::class], "edit.faturamento")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/FaturamentoDelete[/{idfaturamento}]", [PermissionMiddleware::class], "delete.faturamento")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/FaturamentoPreview", [PermissionMiddleware::class], "preview.faturamento")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FaturamentoPreview", null, false);
    }
}
