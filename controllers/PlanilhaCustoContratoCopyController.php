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

class PlanilhaCustoContratoCopyController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoCopyList[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "list.planilha_custo_contrato_copy")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoCopyList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoCopyAdd[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "add.planilha_custo_contrato_copy")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoCopyAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoCopyView[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "view.planilha_custo_contrato_copy")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoCopyView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoCopyEdit[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "edit.planilha_custo_contrato_copy")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoCopyEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoCopyDelete[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "delete.planilha_custo_contrato_copy")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoCopyDelete");
    }
}
