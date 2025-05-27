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

class DissidioAnualController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DissidioAnualList[/{iddissidio_anual}]", [PermissionMiddleware::class], "list.dissidio_anual")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioAnualList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DissidioAnualAdd[/{iddissidio_anual}]", [PermissionMiddleware::class], "add.dissidio_anual")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioAnualAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DissidioAnualView[/{iddissidio_anual}]", [PermissionMiddleware::class], "view.dissidio_anual")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioAnualView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DissidioAnualEdit[/{iddissidio_anual}]", [PermissionMiddleware::class], "edit.dissidio_anual")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioAnualEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DissidioAnualDelete[/{iddissidio_anual}]", [PermissionMiddleware::class], "delete.dissidio_anual")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DissidioAnualDelete");
    }
}
