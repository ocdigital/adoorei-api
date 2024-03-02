# Desafio desenvolvedor back-end (Adoorei)

API rest 

## Requisitos

- [PHP](https://www.php.net/) (versão 8.1.27 )
- [Composer](https://getcomposer.org/) (versão 2.7.1)
- [Laravel](https://laravel.com/) (versão 10.10)
- ...

## Instalação

```bash
# Clone o repositório
git clone https://github.com/ocdigital/adoorei-api.git

# Acesse o diretório do projeto
cd seu-projeto

#Compilar a imagem do aplicação
docker-compose build

#Execute o ambiente em modo de segundo plano
docker-compose up -d

# Instale as dependências do Composer
composer install

# Copie o arquivo de configuração do ambiente
cp .env.example .env

# Configure as variáveis de ambiente no arquivo .env

# Gere a chave de aplicação
php artisan key:generate

# Execute as migrações do banco de dados
php artisan migrate

#Execute a seeder para gerar os produtos
php artisan db:seed --class=ProductSeeder

php artisan db:seed --class=SaleSeeder

# Execute os testes
php artisan test

##Documentação da API (Postman)
https://documenter.getpostman.com/view/2748681/2sA2xb5vSz

#arquivo na raiz do projeto
adoorei.postman_collection.json


