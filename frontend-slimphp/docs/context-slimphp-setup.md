# Context - SlimPHP Setup

## Overview
This tutorial documents the process of setting up a SlimPHP frontend application to communicate with a headless WordPress backend. The setup includes handling common issues and troubleshooting steps encountered during the integration process.

## Prerequisites
- PHP 8.1+
- Composer
- WordPress backend running on localhost:8080
- Basic understanding of PHP and WordPress REST API

## Initial Setup Steps

### 1. Project Creation
```bash
# Create new SlimPHP project in frontend directory
cd frontend-slimphp
composer create-project slim/slim-skeleton .
```

### 2. Environment Configuration
Create `.env` file in project root:
```env
APP_ENV=development
APP_DEBUG=true
WP_API_URL=http://localhost:8080/wp-json
```

### 3. Update Dependencies
Modify `composer.json` to include necessary packages:
```json
{
    "require": {
        "slim/slim": "^4.11",
        "slim/psr7": "^1.6",
        "slim/twig-view": "^3.3",
        "guzzlehttp/guzzle": "^7.5",
        "vlucas/phpdotenv": "^5.5"
    }
}
```

Run:
```bash
composer update
composer install
```

## WordPress Integration

### 1. WordPress Service Setup
Create `src/Application/Services/WordPressService.php`:
```php
<?php

namespace App\Application\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WordPressService
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = $_ENV['WP_API_URL'] ?? 'http://localhost:8080/wp-json';
        
        $this->client = new Client([
            'timeout' => 5,
            'verify' => false
        ]);
    }

    public function getPosts()
    {
        try {
            $url = $this->baseUrl . '/wp/v2/posts';
            error_log('Attempting to fetch posts from: ' . $url);
            
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            
            $body = $response->getBody()->getContents();
            $posts = json_decode($body, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to parse JSON: ' . json_last_error_msg());
            }
            
            return $posts;
            
        } catch (GuzzleException $e) {
            error_log('WordPress API Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
```

### 2. Route Configuration
Update `app/routes.php`:
```php
<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Application\Services\WordPressService;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        try {
            $wpService = new WordPressService();
            $posts = $wpService->getPosts();
            
            return $this->get('view')->render($response, 'home.twig', [
                'posts' => $posts ?? [],
                'error' => null,
                'debug' => [
                    'url' => $_ENV['WP_API_URL'] . '/wp/v2/posts',
                    'env' => $_ENV
                ]
            ]);
        } catch (\Exception $e) {
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
};
```

### 3. Template Setup
Create `templates/home.twig`:
```twig
{% extends "base.twig" %}

{% block content %}
    <h1>Latest Posts</h1>
    
    {% if error %}
        <div style="color: red; padding: 10px; background: #ffebee;">
            Error: {{ error }}
        </div>
    {% endif %}
    
    {% if debug is defined %}
        <div style="background: #e3f2fd; padding: 10px; margin: 10px 0;">
            <strong>Debug Info:</strong><br>
            Attempting to connect to: {{ debug.url }}<br>
            Environment variables: <pre>{{ dump(debug.env) }}</pre>
        </div>
    {% endif %}
    
    {% if posts is empty %}
        <p>No posts found or error occurred.</p>
    {% else %}
        {% for post in posts %}
            <article>
                <h2>{{ post.title.rendered|raw }}</h2>
                <div>{{ post.excerpt.rendered|raw }}</div>
            </article>
        {% endfor %}
    {% endif %}
{% endblock %}
```

## Common Issues and Solutions

### 1. Environment Loading Issue
**Problem**: Environment variables not loading
**Solution**: Add environment loading to `public/index.php` after autoloader:
```php
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
```

### 2. Twig Debug Function Error
**Problem**: "Unknown 'dump' function" error
**Solution**: Enable Twig debug extension in `app/dependencies.php`:
```php
'view' => function (ContainerInterface $container) {
    $twig = Twig::create(
        __DIR__ . '/../templates',
        [
            'cache' => false,
            'debug' => true,
            'auto_reload' => true
        ]
    );
    
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    
    return $twig;
},
```

### 3. WordPress API Connection Issues
**Common Problems**:
- Incorrect API URL in `.env`
- WordPress REST API not accessible
- Request timeout issues

**Solutions**:
1. Verify WordPress API accessibility at `http://localhost:8080/wp-json/wp/v2/posts`
2. Check `.env` configuration
3. Ensure WordPress permalinks are set to "Post name"
4. Add error logging in WordPressService for debugging

### 4. Cache and Server Restart
When making changes:
1. Stop the PHP server (Ctrl+C)
2. Clear any PHP cache files
3. Restart the server: `composer start`

## Running the Application
1. Start WordPress backend on port 8080
2. Start SlimPHP frontend:
```bash
composer start
```
3. Access the application at `http://localhost:8081`

## Additional Notes
- Keep `app/routes.php` and remove any duplicate route files in `config/`
- Consider adding proper error handling for production
- Add styling and additional features as needed

## Next Steps
1. Add pagination for posts
2. Implement proper error handling
3. Add caching layer
4. Style the frontend
5. Add more WordPress API integrations
   