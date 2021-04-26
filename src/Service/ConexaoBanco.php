<?php

namespace src\Service;

abstract class ConexaoBanco
{
    protected $pdo;

    public function __construct()
    {
        try{
            $host = $_ENV['HOST'];
            $port = $_ENV['PORT'];
            $user = $_ENV['USER']; //Padrão é root
            $pass = $_ENV['PASS']; //Padrão é vazio
            $dbname = $_ENV['DB_NAME'];
            $dsn = "mysql:host={$host};dbname={$dbname};port={$port};";
            $this->pdo = new \PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo 'Erro ao conectar ao banco de dados';
        }
    }
}
