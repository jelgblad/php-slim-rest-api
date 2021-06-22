<?php

use DI\Container;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
// use Monolog\Processor\UidProcessor;
use Monolog\Handler\RotatingFileHandler;

$definitions = [
  LoggerInterface::class => DI\factory(function () {
    $logger = new Logger('app');
    // $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new RotatingFileHandler('../log/' . '/app.log', 14));
    $logger->pushHandler(new RotatingFileHandler('../log/' . '/error.log', 14, Monolog\Logger::ERROR, false));

    return $logger;
  }),
];

// Create Container using PHP-DI
$builder = new ContainerBuilder();
$builder->addDefinitions($definitions);
$container = $builder->build();

// $container->set('logger',);

return $container;
