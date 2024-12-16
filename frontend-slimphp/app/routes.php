<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Application\Services\WordPressService;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Services\GraphQLService;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

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

    // GraphQL test route
    $app->get('/graphql-test', function (Request $request, Response $response) {
        try {
            $graphql = new GraphQLService();
            $result = $graphql->query('
                query GetPosts {
                    posts {
                        nodes {
                            id
                            title
                            date
                        }
                    }
                }
            ');

            return $this->get('view')->render($response, 'graphql-test.twig', [
                'posts' => $result['data']['posts']['nodes'] ?? [],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return $this->get('view')->render($response, 'graphql-test.twig', [
                'posts' => [],
                'error' => $e->getMessage()
            ]);
        }
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
