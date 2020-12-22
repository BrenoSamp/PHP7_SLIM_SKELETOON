<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\PersonAction;
use App\Application\Actions\User\AdminAction;
use App\Application\Actions\User\ViewAdminAction;
use App\Application\Actions\User\ViewPersonAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!, Você vai aprender PHP !!!!!!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/people', function (Group $group) {
        $group->get('', PersonAction::class);
        $group->get('/{idperson}', ViewPersonAction::class);
    });

    $app->group('/admin', function (Group $group) {
        $group->get('', ViewAdminAction::class);
        $group->post('/forgot',ViewAdminAction::class);
        $group->post('/users/create', ViewAdminAction::class);
        $group->post('/login', AdminAction::class);
        $group->get('/users/{iduser}', ViewAdminAction::class);
    });
};
