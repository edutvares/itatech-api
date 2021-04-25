<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\ManagerService;
use src\Model\Manager;

final class ManagerController 
{

    private $managerService;

    public function __construct()
    {
        $this->managerService = new ManagerService();
    }

    public function obterTodos(Request $request, Response $response, array $args) 
    {
        $vendas = $this->managerService->obterTodos();
        return $response->withJson($vendas);
    }

    public function inserir(Request $request, Response $response, array $args) 
    {
        $data = $request->getParsedBody();

        if(!isset($data['nome']) || !isset($data['email']) || !isset($data['senha'])) 
        {
            return $response->withJson([ "error" => "Erro: Algum campo não foi preenchido." ]);
        }

        $novoGerente = new Manager();

        $novoGerente->nome = $data['nome'];
        $novoGerente->email = $data['email'];
        $novoGerente->senha = $data['senha'];

        $this->managerService->inserir($novoGerente);

        return $response->withJson([ "message" => "Gerente cadastrado com sucesso!" ]);
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idGerente = $request->getAttribute('id');

        $res = $this->managerService->delete($idGerente);

        if($res)
            return $response->withJson([ "message" => "Gerente deletado com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível deletar o gerente" ]);
    }

}