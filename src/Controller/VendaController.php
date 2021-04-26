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

        try {
            $this->vendaService->inserir($novaVenda);
            return $response->withJson([ "message" => "Venda cadastrada com sucesso!" ], 201);
        } catch (\Throwable $th) {
            return $response->withJson([ "error" => "Erro: Não foi possível cadastrar essa venda. Os dados passados são inválidos" ]);
        }
        

        
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idVenda = $request->getAttribute('id');

        $pesquisaBanco = $this->vendaService->obterPorId($idVenda);

        if(!isset($pesquisaBanco[0])) {
            return $response->withJson([ "error" => "Erro: O id informado não corresponde a nenhuma venda cadastrada" ]);
        }

        $res = $this->vendaService->delete($idVenda);

        if($res)
            return $response->withJson([ "message" => "Venda deletada com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível deletar a venda" ]);
    }

    public function update(Request $request, Response $response, array $args) 
    {

        $data = $request->getParsedBody();
        $idVenda = $request->getAttribute('id');

        if(!isset($data['id_usuario']) || !isset($data['id_produto']) || !isset($idVenda)) {
            return $response->withJson([ "error" => "Erro: Usuario, produto ou ID não informado." ]);
        }

        $pesquisaBanco = $this->vendaService->obterPorId($idVenda);

        if(!isset($pesquisaBanco[0])) {
            return $response->withJson([ "error" => "Erro: O id informado não corresponde a nenhuma venda cadastrada" ]);
        }

        $venda = new Venda();

        $venda->id = $idVenda;
        $venda->idUsuario = $data['id_usuario'];
        $venda->idProduto = $data['id_produto'];

        try {
            $res = $this->vendaService->update($venda);
            return $response->withJson([ "message" => "Venda atualizada com sucesso" ]);
        } catch (\Throwable $th) {
            return $response->withJson([ "error" => "Erro: Não foi possível atualizar a venda. Os dados passados são inválidos" ]);
        }
    }
}