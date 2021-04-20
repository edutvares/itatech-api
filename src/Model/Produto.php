<?php

namespace src\Model;

/*
    Usamos uma Model para representar algo, no nosso caso um Produto, geralmente
    uma model é uma classe que representa uma tabela do banco de dados e possui
    os mesmos atributos para facilitar a troca de informações.
    É uma simples classe com atributos, instanciamos uma dessa para 
    armazenar as informações de um produto.
*/
final class Produto {
    public $id;
    public $nome;
    public $preco;
}