<?php

namespace src\Service;
use src\Model\Usuario;
use src\Service\ConexaoBanco;

final class UsuarioService extends ConexaoBanco
{

    public function obterTodos()
    {
        $usuarios = $this->pdo->query('SELECT id, nome FROM usuario')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $usuarios;
    }

    public function inserir(Usuario $usuario)
    {
        $sql = $this->pdo->prepare('INSERT INTO usuario VALUES (DEFAULT, :nome)');

        $resposta = $sql->execute(array('nome' => $usuario->nome));

        if($resposta) {
            return true;
        }
        return false;
    }

    public function delete(int $id) {
        $sql = $this->pdo->prepare('DELETE FROM usuario WHERE id = :id');

        $resposta = $sql->execute(['id' => $id]);

        return $resposta;
    }

    public function update(Usuario $usuario) {
        $sql = $this->pdo->prepare('UPDATE usuario 
                                    SET nome = :nome
                                    WHERE id = :id');

        $resposta = $sql->execute([
            'id'    =>  $usuario->id,
            'nome'  =>  $usuario->nome,
        ]);

        return $resposta;
    }

}