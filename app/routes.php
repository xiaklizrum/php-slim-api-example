<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Atlas\Orm\Atlas;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    /** @var Atlas $atlas */
    $atlas = $app->getContainer()->get('atlas');

    $app->get('/users', function(Request $request, Response $response, array $args) use ($atlas){
        $users = $atlas->select(/** Atlas Model here */)->fetchRecord();
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->getBody()
            ->write(json_encode($users));
    });

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
