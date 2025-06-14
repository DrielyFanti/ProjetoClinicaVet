# Sistema de Clínica Veterinária

Este é um projeto para gerenciamento de clínicas veterinárias, desenvolvido com Laravel (Backend) e Vue.js (Frontend).

## Como Baixar e Configurar o Projeto

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/projetoClinica.git
cd projetoClinica
```

2. Configure o ambiente de desenvolvimento:
   - Instale o MySQL
   - Instale o PHP 8.1 ou superior
   - Instale o Node.js 16.x ou superior
   - Instale o Composer
   - Instale o NPM ou Yarn

## Descrição Geral

O sistema permite o gerenciamento completo de uma clínica veterinária, incluindo:
- Cadastro e gerenciamento de tutores
- Cadastro e controle de animais
- Agendamento de consultas e procedimentos
- Registro de serviços realizados
- Controle de espécies e raças
- Gestão de diferentes tipos de serviços

## Requisitos do Sistema

- PHP 8.1 ou superior
- Node.js 16.x ou superior
- MySQL 8.0 ou superior
- Composer
- NPM ou Yarn

## Instalação

### 1. Banco de Dados

1. Instale o MySQL em sua máquina
2. Crie um novo banco de dados:
```sql
CREATE DATABASE vet_clinic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
3. Importe o arquivo de estrutura do banco:
```bash
mysql -u seu_usuario -p vet_clinic < bd/vet-clinic.sql
```

### 2. Backend (Laravel)

1. Navegue até a pasta do backend:
```bash
cd backend
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Configure o arquivo .env:
```bash
cp .env.example .env
```

4. Configure as variáveis de ambiente no arquivo .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vet_clinic
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Gere a chave da aplicação:
```bash
php artisan key:generate
```

6. Execute as migrações:
```bash
php artisan migrate
```

7. Inicie o servidor:
```bash
php artisan serve
```

### 3. Frontend (Vue.js)

1. Navegue até a pasta do frontend:
```bash
cd frontend
```

2. Instale as dependências:
```bash
npm install
```

3. Configure o arquivo .env:
```bash
cp .env.example .env
```

4. Configure a URL da API no arquivo .env:
```
VUE_APP_API_URL=http://localhost:8000
```

5. Inicie o servidor de desenvolvimento:
```bash
npm run serve
```

## Estrutura do Banco de Dados

### Tabelas Principais

1. **tutors**
   - Armazena informações dos tutores dos animais
   - Campos principais: nome, CPF, email, telefone, endereço

2. **species**
   - Cadastro de espécies de animais
   - Campos principais: nome da espécie

3. **breeds**
   - Cadastro de raças por espécie
   - Campos principais: nome da raça, espécie relacionada

4. **animals**
   - Registro dos animais atendidos
   - Campos principais: nome, espécie, raça, tutor, data de nascimento, gênero, peso

5. **service_types**
   - Tipos de serviços oferecidos
   - Campos principais: nome, categoria, preço padrão, duração

6. **appointments**
   - Agendamentos de serviços
   - Campos principais: animal, tipo de serviço, data, hora, status

7. **services**
   - Registro de serviços realizados
   - Campos principais: animal, tipo de serviço, data, descrição, preço

## Funcionalidades do Sistema

### Tela Inicial

![Tela de Inicio 1](ImagensSistema/0-%20Pagina%20inicial%201.png)
*Tela de Inicio 1*
![Tela de Inicio 2](ImagensSistema/1-%20Pagina%20inicial%202.png)
*Tela de Inicio 2*

### DashBoard

![Dashboard](ImagensSistema/5-%20Pesquisa%20de%20tutores.png)
*Tela de Dashboard*

### Gestão de Tutores
- Cadastro completo de tutores
- Busca por CPF ou nome
- Histórico de animais por tutor

![Pesquisa de Tutores](ImagensSistema/5-%20Pesquisa%20de%20tutores.png)
*Tela de pesquisa de tutores*

![Cadastro de Tutores](ImagensSistema/6-%20Cadastro%20de%20tutores.png)
*Tela de cadastro de tutores*

### Gestão de Animais
- Cadastro de animais com informações detalhadas
- Vinculação com tutor
- Histórico de atendimentos

![Listagem de Animais](ImagensSistema/7-%20Listagem%20de%20animais.png)
*Tela de listagem de animais*

![Cadastro de Animais](ImagensSistema/8-%20Cadastro%20de%20Animais.png)
*Tela de cadastro de Animais*

### Consultas
- Marcação de consultas e procedimentos
- Controle de status dos Consultas
- Visualização de agenda

![Listagem de Consultas](ImagensSistema/9-%20Listagem%20de%20consultas.png)
*Tela de listagem de Consultas*

![Cadastro de Consultas](ImagensSistema/10-%20Cadastro%20de%20Consulta.png)
*Tela de cadastro de Consultas*

### Serviços
- Registro de serviços realizados
- Controle de preços
- Histórico de atendimentos por animal

![Listagem de Serviços](ImagensSistema/3-%20Listagem%20de%20serviços.png)
*Tela de listagem de serviços*

![Cadastro de Serviços](ImagensSistema/4-%20Cadastro%20de%20Serviços.png)
*Tela de cadastro de Serviços*
