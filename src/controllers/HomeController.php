<?php

namespace MyApp\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

// use Psr\Log\LoggerInterface;

class HomeController extends ControllerBase
{
  // public function __construct(LoggerInterface $logger)
  // {
  //   parent::__construct($logger);
  // }

  public function home(Request $request, Response $response, array $args): Response
  {
    $this->logger->info('Home controller test');

    $data = [
      'message' => 'Welcome home'
    ];

    return $this->json($response, $data)
      ->withStatus(200);
  }
}
