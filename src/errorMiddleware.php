<?php

namespace MyApp;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

/** 
 * @var \Slim\App $app 
 * */

// Define Custom Error Handler
$customErrorHandler = function (
  Request $request,
  \Throwable $exception,
  bool $displayErrorDetails,
  bool $logErrors,
  bool $logErrorDetails
) use ($app) {

  /** @var LoggerInterface $logger */
  $logger = $app->getContainer()->get(LoggerInterface::class);

  $payload['error'] = $exception->getMessage();

  $response = $app->getResponseFactory()->createResponse();
  $response->getBody()->write(
    json_encode($payload, JSON_UNESCAPED_UNICODE)
  );

  if ($exception instanceof HttpBadRequestException) {
    $response = $response->withStatus(400);
  } else if ($exception instanceof HttpNotFoundException) {
    $response = $response->withStatus(404);
  } else {
    $response = $response->withStatus(500);

    if ($displayErrorDetails) {
      $payload['trace'] = $exception->getTrace();
    }

    if ($logErrors) {

      if ($logErrorDetails) {
        $context['trace'] = $exception->getTrace();
      }

      $logger->error($exception->getMessage(), $context);
    }
  }

  return $response
    ->withHeader('Content-Type', 'application/json');
};

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(getenv('APP_ENV') === 'dev', true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

return $errorMiddleware;
