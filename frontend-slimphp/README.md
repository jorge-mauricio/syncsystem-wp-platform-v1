# Slim Framework 4 Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/slimphp/Slim-Skeleton/badge.svg?branch=master)](https://coveralls.io/github/slimphp/Slim-Skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application. You will require PHP 7.4 or newer.

```bash
composer create-project slim/slim-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.

# SynSystem - WP Platform - Front-end slimPHP

## Overview
Frontend application for the SyncSystem WordPress Platform, built with SlimPHP to consume a headless WordPress backend. This application serves as part of a larger monorepo structure that includes a headless WordPress CMS and React TypeScript components for Gutenberg blocks.

## Project Structure
```plaintext
frontend-slimphp/
├── config/              # Application configuration
│   └── settings.php
├── public/             # Web root directory
│   └── index.php
├── src/                # Application source code
│   ├── Application/
│   │   └── Services/
│   ├── Domain/
│   │   └── WordPress/
│   └── Infrastructure/
│       └── WordPress/
├── templates/          # Twig template files
│   └── base.twig
├── .env               # Environment configuration
└── composer.json      # PHP dependencies
```

## Prerequisites
- PHP 8.1 or higher
- Composer 2.2.6 or higher
- WordPress backend running (default: localhost:8080)
- Node.js and npm (for future React integration)
- VS Code (recommended)

## Initial Setup

1. Clone the repository:
```bash
git clone https://github.com/jorge-mauricio/syncsystem-wp-platform-v1.git
cd syncsystem-wp-platform-v1/frontend-slimphp
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Update `.env` with your configuration:
```env
APP_ENV=development
APP_DEBUG=true
WP_API_URL=http://localhost:8080/wp-json
```

5. Start the development server:
```bash
composer start
```
The application will be available at `http://localhost:8081`

## VS Code Configuration
For the best development experience, install the following extensions:
- Twig Language 2 (by mblode)
- PHP Intelephense
- EditorConfig for VS Code

## Development Workflow

### Running the Application
```bash
composer start        # Starts development server
composer test        # Runs test suite
```

### Working with Templates
- Templates are located in the `templates/` directory
- Uses Twig templating engine
- Base template: `templates/base.twig`
- Create new templates in `templates/` directory

### WordPress Integration
- WordPress API communication is handled through `WordPressService`
- Default endpoint: `http://localhost:8080/wp-json`
- GraphQL integration pending (see Roadmap)

## Roadmap
1. GraphQL Integration
   - Install WPGraphQL plugin on WordPress
   - Implement Apollo client
   - Create GraphQL schemas

2. Custom API Endpoints
   - Implement additional WordPress data endpoints
   - Add caching layer
   - Create authentication middleware

3. React Integration
   - Set up TypeScript configuration
   - Implement Gutenberg blocks
   - Create component library

### GraphQL Integration
GraphQL service has been added as an alternative to REST API communication. Currently implemented:
- GraphQL service for making queries
- Test endpoint at `/graphql-test`
- Basic post query functionality

Example query implementation:
```php
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

Test endpoint available at `http://localhost:8081/graphql-test`

## Additional Resources
- [SlimPHP Documentation](https://www.slimframework.com/docs/v4/)
- [Twig Documentation](https://twig.symfony.com/doc/3.x/)
- [WordPress REST API Documentation](https://developer.wordpress.org/rest-api/)
