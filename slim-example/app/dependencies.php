<?php

declare(strict_types=1);

use App\Database\Sql;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Sql::class => function (ContainerInterface $c) {
            $dbhost = getenv('MYSQL_HOST');
            $dbname = getenv('MYSQL_DATABASE');
            $dbuser = getenv('MYSQL_USER');
            $dbpass = getenv('MYSQL_PASSWORD');
            
            return new Sql($dbhost, $dbname, $dbuser, $dbpass);
        }
    ]);
};
