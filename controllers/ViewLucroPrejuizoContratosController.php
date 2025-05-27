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

class ViewLucroPrejuizoContratosController extends ControllerBase
{
    // LucroxPrejuizo (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/ViewLucroPrejuizoContratosList/LucroxPrejuizo", [PermissionMiddleware::class], "list.view_lucro_prejuizo_contratos.LucroxPrejuizo")]
    public function LucroxPrejuizo(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "ViewLucroPrejuizoContratosList", "LucroxPrejuizo");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewLucroPrejuizoContratosList", [PermissionMiddleware::class], "list.view_lucro_prejuizo_contratos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewLucroPrejuizoContratosList");
    }
}
