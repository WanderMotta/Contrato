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

class CargoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CargoList[/{idcargo}]", [PermissionMiddleware::class], "list.cargo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CargoAdd[/{idcargo}]", [PermissionMiddleware::class], "add.cargo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoAdd");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CargoEdit[/{idcargo}]", [PermissionMiddleware::class], "edit.cargo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CargoEdit");
    }
}
