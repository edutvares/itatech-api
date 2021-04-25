# Referência API

Esta API é organizada em torno do REST. Essa API ceita corpos de solicitação em JSON, retorna respostas codificadas por JSON e usa códigos de resposta HTTP padrão, autenticação e verbos.

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
