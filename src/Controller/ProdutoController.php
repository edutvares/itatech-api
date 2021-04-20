<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Você encontratá a Service de Produto em src > Service > ProdutoService
use src\Service\ProdutoService;
//Você encontrará a Model de Produto em src > Model > Produto
use src\Model\Produto;

final class ProdutoController 
{

    private $produtoService;

    //Isso é um construtor, significa que quando a classe ProdutoController for
    //chamada/instanciada, o que estiver dentro dessa função será executado,
    //nesse caso, criar uma instância de ProdutoService para podermos usar as funções da classe ProdutoService.
    public function __construct()
    {
        $this->produtoService = new ProdutoService();
    }

    /*
        Lembra do Request e Response? Como chamamos a função obterTodos para lidar
        com a requisição, os parâmetros também vem para ela e podemos acessar as informações
        aqui dentro. Lembre de importá-los como está ali em cima.
    */
    public function obterTodos(Request $request, Response $response, array $args) 
    {
        $produtos = $this->produtoService->obterTodos();
        return $response->withJson($produtos);
    }

    //Continue desenvolvendo as funções aqui... (Inserir, Atualizar, Remover)

    public function inserir(Request $request, Response $response, array $args) 
    {
        //getParsedBody() irá entregar um array com todas as informações passadas no 
        //corpo da requisição
        //Você pode acessar uma variável passada acessando uma posição do vetor com o nome dela
        //Exemplo: $data['nome']
        $data = $request->getParsedBody();

        //Verificação de segurança, caso o nome ou preco não estiverem na requisição, retorna um erro.
        if(!isset($data['nome']) || !isset($data['preco'])) 
        {
            return $response->withJson([ "error" => "Erro: Nome ou preço estão vazios." ]);
        }

        $novoProduto = new Produto();

        $novoProduto->nome = $data['nome'];
        $novoProduto->preco = $data['preco'];

        $this->produtoService->inserir($novoProduto);

        return $response->withJson([ "message" => "Produto cadastrado com sucesso!" ]);
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idProduto = $request->getAttribute('id');

        $res = $this->produtoService->delete($idProduto);
        
        return $response->withJson([ "res" => $res ]);

        /* if($res)
            return $response->withJson([ "message" => "Produto deletado com sucesso" ]);
        else
            return $response->withJson([ "Erro" => "Não foi possível deletar o produto" ]); */
    }
}