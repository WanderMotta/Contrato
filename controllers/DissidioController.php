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

class DissidioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DissidioList[/{idcargo}]", [PermissionMiddleware::class], "list.dissidio")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioList");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DissidioEdit[/{idcargo}]", [PermissionMiddleware::class], "edit.dissidio")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioEdit");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/DissidioPreview", [PermissionMiddleware::class], "preview.dissidio")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioPreview", null, false);
    }
}
