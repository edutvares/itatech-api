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

        $pesquisaBanco = $this->usuarioService->obterPorNome($data['nome']);

        if(isset($pesquisaBanco[0])) {
            return $response->withJson([ "error" => "Erro: Esse usuário já foi cadastrado." ]);
        }

        $novoUsuario = new Usuario();

        $novoUsuario->nome = $data['nome'];

        $this->usuarioService->inserir($novoUsuario);

        return $response->withJson([ "message" => "Usuario cadastrado com sucesso!" ], 201);
    }

    public function delete(Request $request, Response $response, array $args) 
    {
        $idUsuario = $request->getAttribute('id');

        $pesquisaBanco = $this->usuarioService->obterPorId($idUsuario);

        if(!isset($pesquisaBanco[0])) {
            return $response->withJson([ "error" => "Erro: O id informado não corresponde a nenhum usuário cadastrado" ]);
        }

        $res = $this->usuarioService->delete($idUsuario);

        if($res)
            return $response->withJson([ "message" => "Usuario deletado com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível deletar o Usuario" ]);
    }

    public function update(Request $request, Response $response, array $args) 
    {

        $data = $request->getParsedBody();
        $idUsuario = $request->getAttribute('id');

        if(!isset($data['nome']) || !isset($idUsuario)) {
            return $response->withJson([ "error" => "Erro: Nome ou id não informados." ]);
        }

        $pesquisaBanco = $this->usuarioService->obterPorId($idUsuario);

        if(!isset($pesquisaBanco[0])) {
            return $response->withJson([ "error" => "Erro: O id informado não corresponde a nenhum usuário cadastrado" ]);
        }

        $usuario = new Usuario();

        $usuario->id = $idUsuario;
        $usuario->nome = $data['nome'];
        
        $res = $this->usuarioService->update($usuario);

        if($res)
            return $response->withJson([ "message" => "Usuario atualizado com sucesso" ]);
        else
            return $response->withJson([ "error" => "Erro: Não foi possível atualizar o usuario" ]);
    
    }
}