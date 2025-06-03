# Desafio EasyRev

Um sistema para gerenciamento e previsão de preços de diárias hoteleiras, desenvolvido como parte do Desafio EasyRev.

## 📋 Sobre o Projeto

Este sistema permite a previsão de quartos de hotel baseado em fatores como taxa de ocupação, tipo de quarto e períodos especiais (feriados/fins de semana).

### 🎯 Funcionalidades

- **Histórico de Preços**: Acompanhamento do histórico de preços de cada quarto
- **Previsão Inteligente**: Algoritmo de predição de preços baseado em:
  - Taxa de ocupação atual
  - Tipo de quarto
  - Feriados e fins de semana
- **Interface Responsiva**: Dashboard moderno e intuitivo
- **API RESTful**: Backend robusto com endpoints bem documentados

## 🚀 Tecnologias Utilizadas

### Backend
- PHP 8.2
- Laravel 12
- MySQL 8.0
- Docker & Docker Compose
- Nginx
- PHP-FPM

### Frontend
- Vue.js 3
- Nuxt.js 3
- Tailwind CSS
- Pinia (Gerenciamento de Estado)
- Axios (HTTP Client)

## 📦 Instalação e Configuração

### Pré-requisitos

- Docker e Docker Compose
- Node.js 18+ e npm
- Git

### 1. Clone o Repositório

```bash
git clone https://github.com/Gabrielrc11/desafio_easyrev.git
cd desafio_easyrev
```

### 2. Configuração do Backend

```bash
cd backend

# Configurar variáveis de ambiente
cp .env.example .env

# Construir e iniciar os containers
docker-compose up --build -d

# Instalar dependências
docker-compose exec app composer install

# Gerar chave da aplicação
docker-compose exec app php artisan key:generate

# Executar migrations
docker-compose exec app php artisan migrate

# Popular banco com dados de exemplo
docker-compose exec app php artisan db:seed --class=RoomsAndPricesSeeder
```

O backend estará disponível em: `http://localhost:8080`

### 3. Configuração do Frontend

```bash
cd ../frontend

# Instalar dependências
npm install

# Executar em modo desenvolvimento
npm run dev
```

O frontend estará disponível em: `http://localhost:3000`

## 📡 API Endpoints

### GET /api/rooms
Retorna todos os quartos cadastrados com seus históricos de preços.

**Resposta:**
```json
[
  {
    "id": 1,
    "name": "Quarto Standard 101",
    "type": "Standard",
    "prices": [
      {
        "id": 1,
        "price": 285.00,
        "effective_date": "2025-06-01",
        "occupancy_rate": 75.00,
        "is_holiday_or_weekend": false
      }
    ]
  }
]
```

### POST /api/rooms/{id}/price
Calcula a previsão de preço para um quarto específico.

**Parâmetros:**
```json
{
  "occupancy_rate": 85.5,
  "is_holiday_or_weekend": true
}
```

**Resposta:**
```json
{
  "predicted_price": 342.00,
  "room_type": "Standard",
  "current_price": 285.00
}
```

## 🧮 Algoritmo de Previsão

O sistema utiliza um algoritmo que considera os seguintes fatores:

1. **Taxa de Ocupação**
   - > 80%: +10% no preço base
   - ≤ 80%: -5% no preço base

2. **Tipo de Quarto**
   - Standard: Sem ajuste adicional
   - Deluxe: +10% no preço
   - Suite: +15% no preço

3. **Períodos Especiais**
   - Feriados/Fins de semana: +20% no preço

## 🗄️ Estrutura do Banco de Dados

### Tabela: rooms
- `id`: Identificador único
- `name`: Nome do quarto
- `type`: Tipo de quarto
- `created_at`, `updated_at`: Timestamps

### Tabela: prices
- `id`: Identificador único
- `room_id`: Referência a tabela rooms (FK)
- `price`: Preço da diária
- `effective_date`: Data de vigência
- `occupancy_rate`: Taxa de ocupação
- `is_holiday_or_weekend`: Indicador feriados
- `created_at`, `updated_at`: Timestamps

## 🔧 Desenvolvimento

### Comandos Úteis

**Backend:**
```bash
# Logs dos containers
docker-compose logs -f

# Acessar shell do container
docker-compose exec app bash

# Executar comandos Artisan
docker-compose exec app php artisan [comando]
```