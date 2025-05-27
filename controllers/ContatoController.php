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

class ContatoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ContatoList[/{idcontato}]", [PermissionMiddleware::class], "list.contato")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ContatoAdd[/{idcontato}]", [PermissionMiddleware::class], "add.contato")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ContatoView[/{idcontato}]", [PermissionMiddleware::class], "view.contato")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ContatoEdit[/{idcontato}]", [PermissionMiddleware::class], "edit.contato")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ContatoDelete[/{idcontato}]", [PermissionMiddleware::class], "delete.contato")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ContatoPreview", [PermissionMiddleware::class], "preview.contato")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContatoPreview", null, false);
    }
}
