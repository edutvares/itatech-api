<?php
require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use src\Controller\{
    ProdutoController,
    //Siga importando as outras controllers aqui.
};

// Exibir mensagens de erro detalhadamente
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$config = new \Slim\Container($configuration);
$app = new \Slim\App($config);

/*
    Antes lidávamos com a requisição aqui, porém agora chamamos uma função da 
    classe ProtudoController para lidar com a requisição para nós. Você encontrará
    a função obterTodos em src > Controller > ProdutoController
    Atenção aos ':' antes do nome da função!
*/
$app->get('/produto', ProdutoController::class.':obterTodos');

$app->post('/produto', ProdutoController::class.':inserir');

$app->delete('/produto/{id}', ProdutoController::class.':delete');

//Lembre-se de usar as outras funções do slim para diferentes casos,
//como o post para criar, o put para atualizar e o delete para remover


//Você provavelmente precisará de outra controller para gerenciar as funções do usuário
//$app->get('/usuarios', UsuarioController::class.'obterTodos');

$app->run();
