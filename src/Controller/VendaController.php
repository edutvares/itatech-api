<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\VendaService;
use src\Model\Venda;

final class VendaController 
{

    private $vendaService;

    public function __construct()
    {
        $this->vendaService = new vendaService();
    }

    public function obterTodos(Request $request, Response $response, array $args) 
    {
        $vendas = $this->vendaService->obterTodos();
        return $response->withJson($vendas);
    }

    public function inserir(Request $request, Response $response, array $args) 
    {
        $data = $request->getParsedBody();

        if(!isset($data['id_usuario']) || !isset($data['id_produto'])) 
        {
            return $response->withJson([ "error" => "Erro: Usuario ou produto está vazio." ]);
        }

        $novaVenda = new Venda();

        $novaVenda->idUsuario = $data['id_usuario'];
        $novaVenda->idProduto = $data['id_produto'];

        $this->vendaService->inserir($novaVenda);

        return $response->withJson([ "message" => "Venda cadastrada com sucesso!" ]);
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idVenda = $request->getAttribute('id');

        $res = $this->vendaService->delete($idVenda);

        if($res)
            return $response->withJson([ "message" => "Venda deletada com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível deletar a venda" ]);
    }

    public function update(Request $request, Response $response, array $args) 
    {

        $data = $request->getParsedBody();

        if(!isset($data['id_usuario']) || !isset($data['id_produto'])) {
            return $response->withJson([ "error" => "Erro: Usuario ou produto não informado." ]);
        }

        $venda = new Venda();

        $venda->id = $request->getAttribute('id');
        $venda->idUsuario = $data['id_usuario'];
        $venda->idProduto = $data['id_produto'];
        
        $res = $this->vendaService->update($venda);

        if($res)
            return $response->withJson([ "message" => "Venda atualizada com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível atualizar a venda" ]);
    
    }
}