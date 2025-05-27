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

class PlanilhaCustoContratoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoList[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "list.planilha_custo_contrato")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoAdd[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "add.planilha_custo_contrato")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoView[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "view.planilha_custo_contrato")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoEdit[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "edit.planilha_custo_contrato")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanilhaCustoContratoDelete[/{idplanilha_custo_contrato}]", [PermissionMiddleware::class], "delete.planilha_custo_contrato")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/PlanilhaCustoContratoPreview", [PermissionMiddleware::class], "preview.planilha_custo_contrato")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanilhaCustoContratoPreview", null, false);
    }
}
