# Backend - Desafio EasyRev

## 📋 Sobre

Este é o backend para o Desafio EasyRev. Onde foi construida uma API com os a rotas GET: /api/rooms; POST: /api/rooms/{id}/price.

## 🔧 Tecnologias

- PHP
- Laravel
- MySql
- Docker

## ⚙️ Configuração

### Instalação

1. Clone o repositório
```bash
git clone https://github.com/Gabrielrc11/desafio_easyrev.git
cd desafio_easyrev/backend
```

2. Configure as variáveis de ambiente
```bash
cp .env.example .env
```

3. Construir e iniciar os containers
```bash
docker-compose up --build -d
```

4. Instalar dependências do Composer
```bash
docker-compose exec app composer install
```

5. Gerar a chave da aplicação
```bash
docker-compose exec app php artisan key:generate
```

6. Executar migrations
```bash
docker-compose exec app php artisan migrate
```

7. Gerar a chave da aplicação
```bash
docker-compose exec app php artisan key:generate
```

8. Executar seeders com dados genéricos
```bash
docker-compose exec app php artisan db:seed --class=RoomsAndPricesSeeder
```

O servidor estará rodando em `http://localhost:8080`.

## 📝 API Endpoints

- `GET /api/rooms` - Retorna todos os quartos cadastrados junto com seus respectivos dados.
- `POST /api/rooms/{id}/price` -  Recebe dados de ocupação e informação sobre feriado/fim de semana para calcular a previsão de preço para o próximo dia de um quarto.