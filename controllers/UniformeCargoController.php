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

class UniformeCargoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UniformeCargoList[/{iduniforme_cargo}]", [PermissionMiddleware::class], "list.uniforme_cargo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UniformeCargoAdd[/{iduniforme_cargo}]", [PermissionMiddleware::class], "add.uniforme_cargo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UniformeCargoView[/{iduniforme_cargo}]", [PermissionMiddleware::class], "view.uniforme_cargo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UniformeCargoEdit[/{iduniforme_cargo}]", [PermissionMiddleware::class], "edit.uniforme_cargo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UniformeCargoDelete[/{iduniforme_cargo}]", [PermissionMiddleware::class], "delete.uniforme_cargo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/UniformeCargoPreview", [PermissionMiddleware::class], "preview.uniforme_cargo")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UniformeCargoPreview", null, false);
    }
}
