<?php

namespace src\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\VendaService;//
use src\Model\Venda;//

final class AuthMiddleware
{

    private $vendaService;

    public function __construct()
    {
        $this->vendaService = new vendaService();
    }

    public function login(Request $request, Response $response, $next) {
        //return $next($request, $response);
        return $response->withJson([ "message" => "Foi aqui" ]);
    }
}