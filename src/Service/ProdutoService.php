<?php

namespace src\Service;
use src\Model\Produto;
use src\Service\ConexaoBanco;

final class ProdutoService extends ConexaoBanco
{

    /*
        A camada Service é responsável por realizar a conexão com o banco de dados e
        ler ou escrever dados no banco. Nesta query o que estamos fazendo é selecionar 
        o id, nome e preco de todos os produtos. Depois disso é realizado o fetch dos
        dados e eles são retornados para a ProdutoController, que é quem está chamando a função.
    */
    public function obterTodos()
    {
        $produtos = $this->pdo->query('SELECT id, nome, preco FROM produto')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $produtos;
    }

    public function inserir(Produto $produto)
    {
        $sql = $this->pdo->prepare('INSERT INTO produto VALUES (DEFAULT, :nome, :preco)');

        $resposta = $sql->execute(array('nome' => $produto->nome, 'preco' => $produto->preco));

        if($resposta) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $sql = $this->pdo->prepare('DELETE FROM produto WHERE id = :id');

        $resposta = $sql->execute(array('id' => $id));

        return $resposta;
    }

}