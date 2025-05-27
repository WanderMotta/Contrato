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

class PropostaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PropostaList[/{idproposta}]", [PermissionMiddleware::class], "list.proposta")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PropostaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PropostaAdd[/{idproposta}]", [PermissionMiddleware::class], "add.proposta")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PropostaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PropostaView[/{idproposta}]", [PermissionMiddleware::class], "view.proposta")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PropostaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PropostaEdit[/{idproposta}]", [PermissionMiddleware::class], "edit.proposta")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PropostaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PropostaDelete[/{idproposta}]", [PermissionMiddleware::class], "delete.proposta")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PropostaDelete");
    }
}
