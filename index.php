<?php
require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use src\Controller\{
    ProdutoController,
    UsuarioController,
    VendaController,
    AuthController,
    ManagerController
};

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Exibir mensagens de erro detalhadamente
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$config = new \Slim\Container($configuration);
$app = new \Slim\App($config);

//Rota de configuração de CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//Middleware para dicionar cabeçalhos CORS
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "header" => "X-token",
    "regexp" => "/(.*)/",
    "path" => "/*",
    "ignore" => ["/login", "/adm/init", "/produto/todos"],
    "secret" => $_ENV['SECRET_KEY']
]));

//->add(AuthMiddleware::class.':login')

/*
    Antes lidávamos com a requisição aqui, porém agora chamamos uma função da 
    classe ProtudoController para lidar com a requisição para nós. Você encontrará
    a função obterTodos em src > Controller > ProdutoController
    Atenção aos ':' antes do nome da função!
*/
$app->get('/produto/todos', ProdutoController::class.':obterTodos');
$app->post('/produto', ProdutoController::class.':inserir');
$app->put('/produto/{id}', ProdutoController::class.':update');
$app->delete('/produto/{id}', ProdutoController::class.':delete');

//Lembre-se de usar as outras funções do slim para diferentes casos,
//como o post para criar, o put para atualizar e o delete para remover


//Você provavelmente precisará de outra controller para gerenciar as funções do usuário
//$app->get('/usuarios', UsuarioController::class.'obterTodos');

$app->get('/usuario', UsuarioController::class.':obterTodos');
$app->post('/usuario', UsuarioController::class.':inserir');
$app->put('/usuario/{id}', UsuarioController::class.':update');
$app->delete('/usuario/{id}', UsuarioController::class.':delete');

$app->get('/venda', VendaController::class.':obterTodos');
$app->post('/venda', VendaController::class.':inserir');
$app->put('/venda/{id}', VendaController::class.':update');
$app->delete('/venda/{id}', VendaController::class.':delete');

$app->post('/adm/init', AuthController::class.':admInit');
$app->post('/login', AuthController::class.':login');

$app->get('/gerente', ManagerController::class.':obterTodos');
$app->post('/gerente', ManagerController::class.':inserir');
$app->delete('/gerente/{id}', ManagerController::class.':delete');

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    return $res->withJson(["error" => "Erro: Parametros de requisição inválidos"]);
});

$app->run();

//INSERT INTO `venda`(`id_usuario`, `id_produto`) VALUES (1,5)
//SELECT * FROM venda INNER JOIN produto ON (produto.id = venda.id_produto) INNER JOIN usuario on (usuario.id = venda.id_usuario)

//ESSE AQUI = listar todos os pedidos juntando as duas tabelas
// SELECT venda.id, produto.nome AS produto_nome, produto.preco AS produto_preco, usuario.nome AS usuario_nome FROM venda INNER JOIN produto ON (produto.id = venda.id_produto) INNER JOIN usuario on (usuario.id = venda.id_usuario)