<?php

namespace src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use src\Service\UsuarioService;
use src\Model\Usuario;

final class UsuarioController 
{

    private $usuarioService;

    public function __construct()
    {
        $this->usuarioService = new usuarioService();
    }

    public function obterTodos(Request $request, Response $response, array $args) 
    {
        $usuarios = $this->usuarioService->obterTodos();
        return $response->withJson($usuarios);
    }

    public function inserir(Request $request, Response $response, array $args) 
    {
        $data = $request->getParsedBody();

        if(!isset($data['nome'])) 
        {
            return $response->withJson([ "error" => "Erro: O nome está vazio." ]);
        }

        $novoUsuario = new Usuario();

        $novoUsuario->nome = $data['nome'];

        $this->usuarioService->inserir($novoUsuario);

        return $response->withJson([ "message" => "Usuario cadastrado com sucesso!" ]);
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idUsuario = $request->getAttribute('id');

        $res = $this->usuarioService->delete($idUsuario);

        if($res)
            return $response->withJson([ "message" => "Usuario deletado com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível deletar o Usuario" ]);
    }

    public function update(Request $request, Response $response, array $args) 
    {

        $data = $request->getParsedBody();

        if(!isset($data['nome'])) {
            return $response->withJson([ "error" => "Erro: o novo nome não foi informado." ]);
        }

        $usuario = new Usuario();

        $usuario->id = $request->getAttribute('id');
        $usuario->nome = $data['nome'];
        
        $res = $this->usuarioService->update($usuario);

        if($res)
            return $response->withJson([ "message" => "Usuario atualizado com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível atualizar o usuario" ]);
    
    }
}