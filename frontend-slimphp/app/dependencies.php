<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (ContainerBuilder $containerBuilder) {
    // $containerBuilder->addDefinitions([
    //     LoggerInterface::class => function (ContainerInterface $c) {
    //         $settings = $c->get(SettingsInterface::class);

    //         $loggerSettings = $settings->get('logger');
    //         $logger = new Logger($loggerSettings['name']);

    //         $processor = new UidProcessor();
    //         $logger->pushProcessor($processor);

    //         $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
    //         $logger->pushHandler($handler);

    //         return $logger;
    //     },
    // ]);

    $containerBuilder->addDefinitions([
        // Existing logger definition if you have it
        LoggerInterface::class => function (ContainerInterface $c) {
            // ... your existing logger configuration
        },

        // Add this Twig view definition
        'view' => function (ContainerInterface $container) {
            $twig = Twig::create(
                __DIR__ . '/../templates',    // Path to templates
                [
                    'cache' => false,         // Set to false for development
                    'debug' => true,          // Enable debug mode
                    'auto_reload' => true
                ]
            );

            // Add the debug extension
            $twig->addExtension(new \Twig\Extension\DebugExtension());

            return $twig;
        },
    ]);
};
