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

class MovimentoPlaCustoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MovimentoPlaCustoList[/{idmovimento_pla_custo}]", [PermissionMiddleware::class], "list.movimento_pla_custo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MovimentoPlaCustoAdd[/{idmovimento_pla_custo}]", [PermissionMiddleware::class], "add.movimento_pla_custo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MovimentoPlaCustoView[/{idmovimento_pla_custo}]", [PermissionMiddleware::class], "view.movimento_pla_custo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MovimentoPlaCustoEdit[/{idmovimento_pla_custo}]", [PermissionMiddleware::class], "edit.movimento_pla_custo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MovimentoPlaCustoDelete[/{idmovimento_pla_custo}]", [PermissionMiddleware::class], "delete.movimento_pla_custo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/MovimentoPlaCustoPreview", [PermissionMiddleware::class], "preview.movimento_pla_custo")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MovimentoPlaCustoPreview", null, false);
    }
}
