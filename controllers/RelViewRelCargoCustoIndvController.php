<?php

namespace PHPMaker2024\contratos;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\contratos\Attributes\Delete;
use PHPMaker2024\contratos\Attributes\Get;
use PHPMaker2024\contratos\Attributes\Map;
use PHPMaker2024\contratos\Attributes\Options;
use PHPMaker2024\contratos\Attributes\Patch;
use PHPMaker2024\contratos\Attributes\Post;
use PHPMaker2024\contratos\Attributes\Put;

/**
 * rel_view_rel_cargo_custo_indv controller
 */
class RelViewRelCargoCustoIndvController extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/RelViewRelCargoCustoIndv", [PermissionMiddleware::class], "summary.rel_view_rel_cargo_custo_indv")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelViewRelCargoCustoIndvSummary");
    }
}
