<?php

namespace MyApp;

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

/** @var Container $container */
$container = require '../src/container.php';

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();

// Parse json, form data and xml
$app->addBodyParsingMiddleware();

require '../src/router.php';

$errorMiddleware = require '../src/errorMiddleware.php';

$app->run();
