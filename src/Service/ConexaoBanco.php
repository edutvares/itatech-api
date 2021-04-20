<?php

namespace src\Service;

abstract class ConexaoBanco
{
    protected $pdo;

    public function __construct()
    {
        try{
            $host = 'localhost';
            $port = 3306;
            $user = 'root'; //Padrão é root
            $pass = ''; //Padrão é vazio
            $dbname = 'db_loja';
            $dsn = "mysql:host={$host};dbname={$dbname};port={$port};";
            $this->pdo = new \PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo 'Erro ao conectar ao banco de dados';
        }
    }
}
