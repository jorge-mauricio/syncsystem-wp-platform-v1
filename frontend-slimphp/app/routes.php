<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Application\Services\WordPressService;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    // $app->get('/', function (Request $request, Response $response) {
    //     try {
    //         $wpService = new WordPressService();
    //         $posts = $wpService->getPosts();

    //         // Debug
    //         error_log('Posts data: ' . print_r($posts, true));

    //         return $this->get('view')->render($response, 'home.twig', [
    //             'posts' => $posts ?? [],
    //             'baseUrl' => $_ENV['WP_API_URL'] ?? 'not set'
    //         ]);
    //     } catch (\Exception $e) {
    //         error_log('Error in route handler: ' . $e->getMessage());
    //         return $this->get('view')->render($response, 'home.twig', [
    //             'posts' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // });

    $app->get('/', function (Request $request, Response $response) {
        try {
            error_log('Route handler started');
            $wpService = new WordPressService();
            error_log('WP Service created');

            $posts = $wpService->getPosts();
            error_log('Got posts: ' . print_r($posts, true));

            return $this->get('view')->render($response, 'home.twig', [
                'posts' => $posts ?? [],
                'error' => null,
                'baseUrl' => $_ENV['WP_API_URL'],
                'debug' => [
                    'url' => $_ENV['WP_API_URL'] . '/wp/v2/posts',
                    'env' => $_ENV
                ]
            ]);
        } catch (\Exception $e) {
            error_log('Error in route handler: ' . $e->getMessage());
            return $this->get('view')->render($response, 'home.twig', [
                'posts' => [],
                'error' => $e->getMessage(),
                'debug' => [
                    'url' => $_ENV['WP_API_URL'] . '/wp/v2/posts',
                    'env' => $_ENV
                ]
            ]);
        }
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
