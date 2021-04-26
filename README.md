# Referência API

Esta API é organizada em torno do REST. Essa API aceita corpos de solicitação em JSON, retorna respostas codificadas por JSON e usa códigos de resposta HTTP padrão e autenticação.

## Índice

* [Autenticação](https://github.com/edutvares/itatech-api#autentica%C3%A7%C3%A3o)
* [Endpoints](https://github.com/edutvares/itatech-api#endpoints)
* [Operações em gerentes](https://github.com/edutvares/itatech-api#opera%C3%A7%C3%B5es-em-gerentes)
* [Operações em produtos](https://github.com/edutvares/itatech-api#opera%C3%A7%C3%B5es-em-produtos)
* [Operações em usuários](https://github.com/edutvares/itatech-api#opera%C3%A7%C3%B5es-em-usu%C3%A1rios)
* [Operações em vendas](https://github.com/edutvares/itatech-api#opera%C3%A7%C3%B5es-em-vendas)

## Autenticação

Esta API usa tokens JWT para autenticar solicitações.

### Primeiro Gerente

Para utilizar a API é necessário um Gerente Autenticado.
Criamos o nosso primeiro gerente a Enviando uma solicitação ´POST´ para ´/adm/init´ com o seguinte corpo em JSON

```json
{
  "nome": "João Pistoleiro",
  "email": "pistolinha@dominiomaneiro.com",
  "senha": "umaSenhaForte"
}
```

Obs: Após a criação do primeiro Gerente esta rota não estará mais disponível

### Obtendo token

Para quase todas requisições é necessário o uso do token JWT
Você pode obter um token enviando e-mail e senha para a rota ```/login```

Exemplo de entrada:
```json
{
	"email": "pistolinha@dominiomaneiro.com",
	"senha": "123456"
}
```

Exemplo de resposta:
```json
{
  "gerente": {
    "id": "1",
    "nome": "João Pistoleiro",
    "email": "pistolinha@dominiomaneiro.com"
  },
  "token": "<token-de-acesso>"
}
```

## Endpoints
Todas as requisições necessitam do Header ```X-token``` com o token JWT

### Operações em gerentes

Estas rotas gerenciam a criação, listagem e deleção de Gerentes

#### GET /gerente
* Autenticação necessária

Retorna todos os gerentes cadastrados

Exemplo de saída: 
```json
[
  {
    "id": "1",
    "nome": "Carlinhos",
    "email": "carlinhos@gmail.com",
    "senha": "123456"
  },
  {
    "id": "2",
    "nome": "Pedrinho",
    "email": "pedrinho@gmail.com",
    "senha": "123456"
  }
  ...
]
```

#### POST /gerente
* Autenticação necessária

Cadastra um novo gerente

Exemplo de entrada: 
```json
{
  "nome": "João Pistoleiro",
  "email": "pistolinha@dominiomaneiro.com",
  "senha": "umaSenhaForte"
}
```

#### DELETE /gerente/<id>
* Autenticação necessária

Remove um Gerente pelo seu respectivo ID

### Operações em produtos

Estas rotas gerenciam a criação, listagem, edição e deleção de Produtos

#### GET /produto/todos

Retorna todos os produtos cadastrados

Exemplo de saída:
```json
[
  {
    "id": "1",
    "nome": "Boneca",
    "preco": "25.00"
  },
  {
    "id": "2",
    "nome": "Havaiana",
    "preco": "35.00"
  }
]
```

#### POST /produto
* Autenticação necessária

Adiciona um novo produto

Exemplo de entrada:
```json
{
	"nome": "Havaiana",
	"preco": 35
}
```

#### PUT /produto/<id>
* Autenticação necessária

Atualiza um produto já cadastrado

Exemplo de entrada:
```json
{
	"nome": "Havaiana",
	"preco": 50
}
```

#### DELETE /produto/<id>
* Autenticação necessária

Remove um Produto pelo seu respectivo ID

### Operações em usuários

Estas rotas gerenciam a criação, listagem, edição e deleção de Usuários

#### GET /usuario
* Autenticação necessária

Retorna todos os usuários cadastrados

#### POST /usuario
* Autenticação necessária

Cadastra um novo usuário

Exemplo de entrada:
```json
{
	"nome": "Carlos"
}
```

#### PUT /usuario/<id>
* Autenticação necessária

Edita um usuário já cadastrado

Exemplo de entrada:
```json
{
	"nome": "Pedro"
}
```

#### DELETE /usuario/<id>
* Autenticação necessária

Remove um usuário pelo seu respectivo ID

### Operações em vendas
Estas rotas gerenciam a criação, listagem, edição e deleção de Vendas

#### GET /venda
* Autenticação necessária

Retorna uma lista com todas as vendas

Exemplo de saída:
```json
[
  {
    "id": "2",
    "id_produto": "3",
    "produto_nome": "Bolinha de queijo",
    "produto_preco": "4.00",
    "id_usuario": "1",
    "usuario_nome": "Pedro"
  },
  {
    "id": "3",
    "id_produto": "2",
    "produto_nome": "Havaiana",
    "produto_preco": "35.00",
    "id_usuario": "2",
    "usuario_nome": "Carlos"
  }
  ...
]
```

#### POST /venda
* Autenticação necessária

Realizar uma nova venda

Exemplo de entrada:
```json
{
	"id_produto": 2,
	"id_usuario": 1
}
```

#### PUT /venda/<id>
* Autenticação necessária

Atualizar uma venda pelo seu respectivo ID

Exemplo de entrada:
```json
{
	"id_produto": 4,
	"id_usuario": 7
}
```

#### DELETE /venda/<id>
* Autenticação necessária

Remove uma venda pelo seu respectivo ID