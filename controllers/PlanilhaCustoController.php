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

class PlanilhaCustoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoList[/{idplanilha_custo}]", [PermissionMiddleware::class], "list.planilha_custo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoAdd[/{idplanilha_custo}]", [PermissionMiddleware::class], "add.planilha_custo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoView[/{idplanilha_custo}]", [PermissionMiddleware::class], "view.planilha_custo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoEdit[/{idplanilha_custo}]", [PermissionMiddleware::class], "edit.planilha_custo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoDelete[/{idplanilha_custo}]", [PermissionMiddleware::class], "delete.planilha_custo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/PlanilhaCustoPreview", [PermissionMiddleware::class], "preview.planilha_custo")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoPreview", null, false);
    }
}
