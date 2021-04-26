<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\ManagerService;
use src\Model\Manager;

use \Firebase\JWT\JWT;

final class AuthController 
{

    private $managerService;

    public function __construct()
    {
        $this->managerService = new ManagerService();
    }

    public function admInit(Request $request, Response $response, array $args) {
        $managers = $this->managerService->obterTodos();

        if(count($managers) != 0) {
            return $response->withJson([ "error" => "Erro: Operação não permitida" ], 401);
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

        return $response->withJson([ "message" => "Gerente cadastrado com sucesso!" ], 201);
    }

    public function login(Request $request, Response $response, array $args) {
        // Toda a lógica de criação do JWT

        $data = $request->getParsedBody();

        if(!isset($data['email']) || !isset($data['senha']) ) 
        {
            return $response->withJson([ "error" => "Erro: Parametros incompletos." ]);
        }

        $manager = $this->managerService->obterPorEmail($data['email']);

        if(!isset($manager[0]['id'])) {
            return $response->withJson(['error' => "Erro: Usuario ou senha inválidos"]);
        }
        
        if($manager[0]['senha'] != $data['senha']) {
            return $response->withJson(['error' => "Erro: Usuario ou senha inválidos"]);
        }

        $key = $_ENV['SECRET_KEY'];
        $payload = array(
            "id"    => $manager[0]['id'],
            "nome"  => $manager[0]['nome'],
            "email" => $manager[0]['email']
        );

        $jwt = JWT::encode($payload, $key);

        return $response->withJson(array(
            'gerente' => $payload,
            'token' => $jwt,
        ));
    }
}