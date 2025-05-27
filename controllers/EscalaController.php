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

class EscalaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/EscalaList[/{idescala}]", [PermissionMiddleware::class], "list.escala")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EscalaList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/EscalaView[/{idescala}]", [PermissionMiddleware::class], "view.escala")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EscalaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/EscalaEdit[/{idescala}]", [PermissionMiddleware::class], "edit.escala")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EscalaEdit");
    }
}
