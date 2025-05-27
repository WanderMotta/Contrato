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

class ViewInsumoPropostaDetalhadaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumoPropostaDetalhadaList[/{idmov_insumo_cliente}]", [PermissionMiddleware::class], "list.view_insumo_proposta_detalhada")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumoPropostaDetalhadaList");
    }
}
