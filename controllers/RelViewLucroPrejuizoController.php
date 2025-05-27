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
 * rel_view_lucro_prejuizo controller
 */
class RelViewLucroPrejuizoController extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/RelViewLucroPrejuizo", [PermissionMiddleware::class], "summary.rel_view_lucro_prejuizo")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelViewLucroPrejuizoSummary");
    }

    // LucroxPrejuizo (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/RelViewLucroPrejuizo/LucroxPrejuizo", [PermissionMiddleware::class], "summary.rel_view_lucro_prejuizo.LucroxPrejuizo")]
    public function LucroxPrejuizo(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "RelViewLucroPrejuizoSummary", "LucroxPrejuizo");
    }
}
