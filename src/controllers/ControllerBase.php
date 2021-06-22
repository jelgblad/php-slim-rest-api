<?php

namespace MyApp\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class ControllerBase
{
  protected $logger;

  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  protected function json(Response $response, $data)
  {
    $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
    $response->getBody()->write($payload);

    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
