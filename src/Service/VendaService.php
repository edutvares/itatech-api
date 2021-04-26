<?php

namespace src\Service;
use src\Model\Venda;
use src\Service\ConexaoBanco;

final class VendaService extends ConexaoBanco
{

    public function obterTodos()
    {
        $vendas = $this->pdo->query('SELECT 
                                            venda.id, 
                                            venda.id_produto,
                                            produto.nome AS produto_nome, 
                                            produto.preco AS produto_preco, 
                                            venda.id_usuario,
                                            usuario.nome AS usuario_nome 
                                        FROM venda 
                                        INNER JOIN produto ON (produto.id = venda.id_produto) 
                                        INNER JOIN usuario on (usuario.id = venda.id_usuario)')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $vendas;
    }

    public function obterPorId(int $id) {
        $stmt = $this->pdo->prepare('SELECT 
                                        venda.id, 
                                        venda.id_produto,
                                        produto.nome AS produto_nome, 
                                        produto.preco AS produto_preco, 
                                        venda.id_usuario,
                                        usuario.nome AS usuario_nome 
                                    FROM venda 
                                    INNER JOIN produto ON (produto.id = venda.id_produto) 
                                    INNER JOIN usuario on (usuario.id = venda.id_usuario)
                                    WHERE venda.id = :id 
                                    LIMIT 1');
        

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inserir(Venda $venda)
    {
        $sql = $this->pdo->prepare('INSERT INTO venda VALUES (DEFAULT, :id_usuario, :id_produto)');

        $resposta = $sql->execute([
            'id_usuario' => $venda->idUsuario,
            'id_produto' => $venda->idProduto
        ]);

        if($resposta) {
            return true;
        }
        return false;
    }

    public function delete(int $id) {
        $sql = $this->pdo->prepare('DELETE FROM venda WHERE id = :id');

        $resposta = $sql->execute(['id' => $id]);

        return $resposta;
    }

    public function update(Venda $venda) {
        $sql = $this->pdo->prepare('UPDATE venda 
                                    SET id_usuario = :id_usuario, id_produto = :id_produto
                                    WHERE id = :id');

        $resposta = $sql->execute([
            'id'    =>  $venda->id,
            'id_usuario'  =>  $venda->idUsuario,
            'id_produto'  =>  $venda->idProduto,
        ]);

        return $resposta;
    }

}