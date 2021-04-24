<?php

namespace src\Service;
use src\Model\Manager;
use src\Service\ConexaoBanco;

final class AuthService extends ConexaoBanco
{

    public function obterTodos()
    {
        $managers = $this->pdo->query('SELECT * FROM manager')->fetchAll(\PDO::FETCH_ASSOC);
        return $managers;
    }

    public function inserir(Manager $manager)
    {
        $sql = $this->pdo->prepare('INSERT INTO manager VALUES (DEFAULT, :nome, :email, :senha)');

        $resposta = $sql->execute([
            'nome' => $manager->nome,
            'email' => $manager->email,
            'senha' => $manager->senha
        ]);

        if($resposta) {
            return true;
        }
        return false;
    }

}