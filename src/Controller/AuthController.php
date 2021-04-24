<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\AuthService;
use src\Model\Manager;

final class AuthController 
{

    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function obterTodos(Request $request, Response $response, array $args) 
    {
        $vendas = $this->authService->obterTodos();
        return $response->withJson($vendas);
    }

    public function admInit(Request $request, Response $response, array $args) {
        $managers = $this->authService->obterTodos();

        if(count($managers) != 0) {
            return $response->withJson([ "error" => "Erro: Operação não permitida" ]);
        }

        $data = $request->getParsedBody();

        if(!isset($data['nome']) || !isset($data['email']) || !isset($data['senha']) ) 
        {
            return $response->withJson([ "error" => "Erro: Parametros incompletos." ]);
        }

        $novoGerente = new Manager();

        $novoGerente->nome = $data['nome'];
        $novoGerente->email = $data['email'];
        $novoGerente->senha = $data['senha'];

        $this->authService->inserir($novoGerente);

        return $response->withJson([ "message" => "Gerente cadastrado com sucesso!" ]);
    }
}