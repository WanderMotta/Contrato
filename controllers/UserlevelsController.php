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

class UserlevelsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UserlevelsList[/{UserLevelID}]", [PermissionMiddleware::class], "list.userlevels")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserlevelsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UserlevelsAdd[/{UserLevelID}]", [PermissionMiddleware::class], "add.userlevels")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserlevelsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UserlevelsView[/{UserLevelID}]", [PermissionMiddleware::class], "view.userlevels")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserlevelsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UserlevelsEdit[/{UserLevelID}]", [PermissionMiddleware::class], "edit.userlevels")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserlevelsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UserlevelsDelete[/{UserLevelID}]", [PermissionMiddleware::class], "delete.userlevels")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserlevelsDelete");
    }
}
