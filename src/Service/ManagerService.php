<?php

namespace src\Service;
use src\Model\Manager;
use src\Service\ConexaoBanco;

final class ManagerService extends ConexaoBanco
{

    public function obterTodos()
    {
        $managers = $this->pdo->query('SELECT * FROM manager')->fetchAll(\PDO::FETCH_ASSOC);
        return $managers;
    }

    public function obterPorId($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM manager WHERE id = :id LIMIT 1');
        

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterPorEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM manager WHERE email = :email LIMIT 1');
        

        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

    public function delete(int $id) {
        $sql = $this->pdo->prepare('DELETE FROM manager WHERE id = :id');

        $resposta = $sql->execute(['id' => $id]);

        return $resposta;
    }

}