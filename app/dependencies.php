<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use Atlas\Orm\AtlasBuilder;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);
    $container['atlas'] = function ($container) {
        $args = $container['settings']['atlas']['pdo'];
        $atlasBuilder = new AtlasBuilder(...$args);
        $atlasBuilder->setFactory(function ($class) use ($container) {
            if ($container->has($class)) {
                return $container->get($class);
            }
            return new $class();
        });
        return $atlasBuilder->newAtlas();
    };
};
