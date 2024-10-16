# Teste de Desenvolvedor - 7Cantos

Este repositório contém a solução para o teste de desenvolvedor solicitado pela 7Cantos, que envolve o uso de tecnologias como React e Laravel para criar uma aplicação de gerenciamento de tarefas. O teste foi dividido em duas partes: **Frontend** (React) e **Backend** (Laravel), com questões extras para pontos bônus.

## Descrição do Desafio

O teste é composto por 5 questões principais, além de questões extras para ganhar pontos bônus. O objetivo é testar as habilidades no desenvolvimento web utilizando **React** para o frontend e **Laravel** para o backend.

1. (React) Escreva uma função React que receba um array de Tarefas e retorne uma lista de
elementos li com as tarefas.

Arquivo com a resposta: [App.jsx](frontend/src/App.jsx)

2. (React) Escreva um componente React que exiba uma lista de tarefas, com a possibilidade
de adicionar, remover e marcar como concluída cada tarefa.

Arquivo com a resposta: [App.jsx](frontend/src/App.jsx)

3. (Laravel) Crie um model de tarefas no Laravel com os seguintes campos: id, titulo, estado
concluído ou não e responsável.

```
php artisan make:model Task -m
```
Arquivos da resposta:
 - [Task.php](backend/app/Models/Task.php) -> Model
 - [2024_10_12_122011_create_tasks_table.php](backend/database/migrations/2024_10_12_122011_create_tasks_table.php) -> Migration

4. (Laravel) Crie um controller no Laravel que exiba uma lista de tarefas.

```
php artisan make:controller Api\\TaskController --resource --api

```
*--resource é utilizado para gerar o controller já com toda a estrutura de funções de um CRUD.
*--api informa que será um resource de api e não cria funções. relacionadas com a visualização de formulários como a create e a edit.

Arquivo da resposta:
 - [TaskController.php](backend/app/Http/Controllers/Api/TaskController.php)

5. (Laravel) Crie uma rota no Laravel que permita criar um nova tarefa.

```
Route::apiResource('tasks', TaskController::class)->except('show');
```
*Como foi utilizado o padrão de resource no controller, não é necessário definir explicitamente todas as rotas.

## Tecnologias Utilizadas

- **Frontend**: React.js
- **Backend**: Laravel 10
- **API**: DummyJSON para simular lista de tarefas
- **Banco de Dados**: MySQL
- **Outros**: Axios, Tailwind CSS, Filament

## Backend - Laravel

O backend do projeto foi desenvolvido com Laravel, utilizando boas práticas de arquitetura RESTful e recursos avançados do framework para garantir a segurança, escalabilidade e organização do código.

**A aplicação pode ser vista em funcionamento neste** [link](https://sandybrown-ferret-357721.hostingersite.com/login)

**A ducumentação dos endpoints da API está disponível** [aqui](https://app.swaggerhub.com/apis/GermanoNunes-981/7Cantos/1.0.0)

### 1. Estrutura RESTful API com Laravel API Resources

O projeto segue o padrão REST para a comunicação via API. A utilização de API Resources permite personalizar as respostas da API, garantindo que apenas os dados necessários sejam retornados e mantendo a consistência do formato da resposta.

```
php artisan make:resource TaskResource

```
Arquivo gerado: [TaskResource.php](backend/app/Http/Resources/TaskResource.php)

### 2. Utilização de UUIDs para Identificação

Para melhorar a segurança e evitar que os IDs numéricos exponham a quantidade de registros, o projeto utiliza UUIDs como identificadores das tarefas. Isso é facilmente implementado nas models com o uso da trait ***HasUuids*** nas versões mais recentes do Laravel.

### 3. Observers para Regras de Negócio

Para as tarefas, foi criado um TaskObserver que gerencia o campo finished_at da seguinte maneira:

- Quando uma tarefa é marcada como concluída, o campo finished_at é preenchido com a data e hora atuais.
- Quando o status da tarefa é alterado para não concluída, o campo finished_at é zerado.
Isso automatiza o controle de quando uma tarefa foi finalizada, sem necessidade de interações manuais.

```
php artisan make:observer TaskObserver --model=Task 

```
Arquivo gerado: [TaskObserver.php](backend/app/Observers/TaskObserver.php)

### 4. Validação com Form Requests

O projeto utiliza Form Requests para gerenciar e centralizar as validações das requisições, garantindo a integridade dos dados enviados para a API. Cada ação de criação ou atualização de uma tarefa é validada utilizando classes dedicadas, como o ***TaskFormRequest***, que facilita a manutenção e organização do código.

```
php artisan make:request TaskFormRequest 

```
Arquivo gerado: [TaskFormRequest.php](backend/app/Http/Requests/TaskFormRequest.php)

### 5. Filtros Automáticos com Global Scopes

Um **Global Scope** foi implementado para garantir que os usuários possam visualizar apenas suas próprias tarefas. Esse filtro automático assegura que todas as consultas de tarefas sejam feitas com base no usuário autenticado.

```
protected static function booted(): void
{
    static::addGlobalScope('owner', function (Builder $query) {
        if (auth()->hasUser()) {
            $query->where('user_id', auth()->user()->id);
        }
    });
}

```

### 6. Painel Administrativo com FilamentPHP v3

O gerenciamento das tarefas é realizado através de um painel administrativo construído com [FilamentPHP v3](https://filamentphp.com/docs/3.x/panels/installation).

### 7. Autenticação e Autorização

O projeto implementa autenticação de usuários com tokens de acesso utilizando **Laravel Sanctum**, garantindo que apenas usuários autenticados possam acessar e modificar os dados das tarefas via API.

## Frontend - React

Este é um aplicativo de gerenciamento de tarefas que permite ao usuário adicionar, marcar como concluídas e remover tarefas. O projeto é construído em React e utiliza a API https://dummyjson.com/todos para carregar uma lista de tarefas. Além disso, o usuário pode alternar entre carregar as tarefas de uma fonte local ([todos.json](frontend/src/services/todos.json)) e a API externa.

**A aplicação pode ser vista em funcionamento neste** [link](https://7cantos-todo-list-git-main-grmnunes-projects.vercel.app/)

### Descrição das funcionalidades

Principais Funcionalidades:
Adicionar Tarefas:
O usuário pode adicionar novas tarefas preenchendo o formulário e clicando em "Add Task". A nova tarefa é exibida imediatamente na lista de tarefas pendentes.

- Marcar Tarefas como Concluídas:
  - O usuário pode marcar uma tarefa como concluída. Tarefas concluídas são separadas na interface.

- Remover Tarefas:
  - Tarefas podem ser removidas da lista clicando no botão de remover. Isso elimina permanentemente a tarefa da lista.

- Alternar Fonte de Dados (Local/URL):
  - A aplicação oferece um botão para alternar entre o carregamento de tarefas de uma fonte local (dados estáticos) ou de uma URL externa (API).

Fonte Local: Um conjunto de tarefas pré-definido no código.
API Externa: Uma lista de tarefas carregada da URL https://dummyjson.com/todos.

## Como Executar o Projeto

Siga os passos abaixo para rodar o projeto localmente:

### Pré-requisitos

- [Node.js](https://nodejs.org/) >= 18
- [Composer](https://getcomposer.org/)
- [PHP](https://www.php.net/) >= 8.1

### Instruções

1. Clone este repositório:

   ```
   git clone git@github.com:grmnunes/7cantos-todo-list.git

   ```

2. Navegue até o diretório do projeto:

```
cd 7cantos-todo-list
```
#### Configuração do Backend (Laravel 10)

1. Navegue até o diretório do projeto:

```
cd backend
```

2. Instalar dependências do Laravel

```
composer install
```

3. Configurar o arquivo .env
Crie uma cópia do arquivo .env.example:

```
cp .env.example .env
```

Abra o arquivo .env e configure as seguintes variáveis, principalmente as relacionadas ao banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```
4. Gerar a chave da aplicação

```
php artisan key:generate
```

5.  Rodar as migrations
Execute as migrações para criar as tabelas no banco de dados:

```
php artisan migrate
```

6.  Executar o projeto localmente

```
php artisan serve
```
O servidor será iniciado, normalmente em [http://127.0.0.1:8000](http://127.0.0.1:8000).

#### Configuração do Frontend React + Vite

1. Navegue até o diretório do projeto:

```
cd frontend
```

2. Instalar dependências do projeto

```
npm install

ou

yarn install
```

3.  Executar o projeto localmente

```
npm run dev

ou

yarn dev
```
O servidor será iniciado, normalmente em [http://127.0.0.1:8000](http://127.0.0.1:5173).
