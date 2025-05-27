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

class BeneficiosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/BeneficiosList[/{idbeneficios}]", [PermissionMiddleware::class], "list.beneficios")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BeneficiosList");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/BeneficiosEdit[/{idbeneficios}]", [PermissionMiddleware::class], "edit.beneficios")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BeneficiosEdit");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/BeneficiosPreview", [PermissionMiddleware::class], "preview.beneficios")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BeneficiosPreview", null, false);
    }
}
