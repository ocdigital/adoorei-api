# Desafio Back-end - API Rest

Este projeto é uma API REST desenvolvida para o desafio de desenvolvedor back-end.

## Objetivo
Utilizando o  <a href=“https://laravel.com/docs/10.x“>Laravel</a> cria uma API rest, que resolva o seguinte cenário:


A Loja ABC LTDA, vende produtos de diferentes nichos. No momento precisamos registrar a venda de celulares.

Não vamos nos preocupar com o cadastro de produtos, porém precisamos ter uma tabela em nosso banco contendo os aparelhos celulares que vão ser vendidos, por exemplo:

```json
[
    {
        "name": "Celular 1",
        "price": 1.800,
        "description": "Lorenzo Ipsulum"
    },
    {
        "name": "Celular 2",
        "price": 3.200,
        "description": "Lorem ipsum dolor"
    },
    {
        "name": "Celular 3",
        "price": 9.800,
        "description": "Lorem ipsum dolor sit amet"
    }
]
```

Uma vez que temos os produtos em nosso banco, vamos seguir com o registro de venda desses aparelhos.

Não vamos nós preucupar com informações do comprador, dados de pagamento, entrega, possibilidade de descontos.

Temos que registrar somente a venda. 

Então nossa consulta vai retornar algo como:
```json
{
  "sales_id": "202301011",
  "amount": 8200,
  "products": [
    {
      "product_id": 1,
      "nome": "Celular 1",
      "price": 1.800,
      "amount": 1
    },
    {
      "product_id": 2,
      "nome": "Celular 2",
      "price": 3.200,
      "amount": 2
    },
  ]
}
```

Nossa API vai ter endpoints que possibilitam

* Listar produtos disponíveis
* Cadastrar nova venda
* Consultar vendas realizadas
* Consultar uma venda específica
* Cancelar uma venda
* Cadastrar novas produtos a uma venda

## Requisitos

- [PHP](https://www.php.net/) (versão 8.1.27)
- [Composer](https://getcomposer.org/) (versão 2.7.1)
- [Laravel](https://laravel.com/) (versão 10.10)

## Instalação

1. **Clone o Repositório:**
    ```bash
    git clone https://github.com/ocdigital/adoorei-api.git
    ```

2. **Acesse o Diretório do Projeto:**
    ```bash
    cd seu-projeto
    ```

3. **Compilar a Imagem da Aplicação:**
    ```bash
    docker-compose build
    ```

4. **Execute o Ambiente em Modo de Segundo Plano:**
    ```bash
    docker-compose up -d
    ```

5. **Instale as Dependências do Composer:**
    ```bash
    composer install
    ```

6. **Copie o Arquivo de Configuração do Ambiente:**
    ```bash
    cp .env.example .env
    ```

7. **Configure as Variáveis de Ambiente no Arquivo `.env`:**
    *(Edite o arquivo `.env` com suas configurações)*

8. **Gere a Chave de Aplicação:**
    ```bash
    php artisan key:generate
    ```

9. **Entre no Container para Executar as Migrações:**
    *(Encontre o nome do container)*
    ```bash
    docker ps
    docker exec -it nome-do-container bash
    ```

10. **Execute as Migrações do Banco de Dados:**
    ```bash
    php artisan migrate
    ```

11. **Execute o Seeder para Gerar os Produtos:**
    ```bash
    php artisan db:seed --class=ProductSeeder
    ```

12. **Opcional: Gerar Vendas**
    ```bash
    php artisan db:seed --class=SaleSeeder
    ```

13. **Execute os Testes:**
    ```bash
    php artisan test
    ```

## Documentação da API (Postman)

Explore a documentação da API no Postman [aqui](https://documenter.getpostman.com/view/2748681/2sA2xb5vSz).

Arquivo do Postman disponível na raiz do projeto.
