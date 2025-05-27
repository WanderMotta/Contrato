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
 * rel_comunicado_interno controller
 */
class RelComunicadoInternoController extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/RelComunicadoInterno", [PermissionMiddleware::class], "summary.rel_comunicado_interno")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelComunicadoInternoSummary");
    }
}
