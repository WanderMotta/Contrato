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

class TipoIntrajornadaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoIntrajornadaList[/{idtipo_intrajornada}]", [PermissionMiddleware::class], "list.tipo_intrajornada")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoIntrajornadaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoIntrajornadaAdd[/{idtipo_intrajornada}]", [PermissionMiddleware::class], "add.tipo_intrajornada")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoIntrajornadaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoIntrajornadaView[/{idtipo_intrajornada}]", [PermissionMiddleware::class], "view.tipo_intrajornada")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoIntrajornadaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoIntrajornadaEdit[/{idtipo_intrajornada}]", [PermissionMiddleware::class], "edit.tipo_intrajornada")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoIntrajornadaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoIntrajornadaDelete[/{idtipo_intrajornada}]", [PermissionMiddleware::class], "delete.tipo_intrajornada")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoIntrajornadaDelete");
    }
}
