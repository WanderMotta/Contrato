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

class LocalController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/LocalList[/{idlocal}]", [PermissionMiddleware::class], "list.local")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/LocalAdd[/{idlocal}]", [PermissionMiddleware::class], "add.local")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/LocalView[/{idlocal}]", [PermissionMiddleware::class], "view.local")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/LocalEdit[/{idlocal}]", [PermissionMiddleware::class], "edit.local")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/LocalDelete[/{idlocal}]", [PermissionMiddleware::class], "delete.local")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalDelete");
    }
}
