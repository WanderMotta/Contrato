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

class UniformeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UniformeList[/{iduniforme}]", [PermissionMiddleware::class], "list.uniforme")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UniformeAdd[/{iduniforme}]", [PermissionMiddleware::class], "add.uniforme")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeAdd");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UniformeEdit[/{iduniforme}]", [PermissionMiddleware::class], "edit.uniforme")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeEdit");
    }
}
