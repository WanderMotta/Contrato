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

class InsumoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/InsumoList[/{idinsumo}]", [PermissionMiddleware::class], "list.insumo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InsumoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/InsumoAdd[/{idinsumo}]", [PermissionMiddleware::class], "add.insumo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InsumoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/InsumoView[/{idinsumo}]", [PermissionMiddleware::class], "view.insumo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InsumoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/InsumoEdit[/{idinsumo}]", [PermissionMiddleware::class], "edit.insumo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InsumoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/InsumoDelete[/{idinsumo}]", [PermissionMiddleware::class], "delete.insumo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InsumoDelete");
    }
}
