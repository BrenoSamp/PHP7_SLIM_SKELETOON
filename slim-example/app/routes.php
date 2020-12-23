<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ListAdminAction;
use App\Application\Actions\User\PersonAction;
use App\Application\Actions\User\AdminAction;
use App\Application\Actions\User\CreateAdminAction;
use App\Application\Actions\User\DeleteAdminAction;
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
        $group->post('/create', CreateAdminAction::class)->setName('C');
        $group->get('/list', ListAdminAction::class)->setName('R');
        $group->post('/list/{iduser}', ViewAdminAction::class)->setName('U');
        $group->get('/delete/{iduser}',DeleteAdminAction::class)->setName('D');
        $group->post('/login', AdminAction::class);
        
    });
};
