# Teste de Desenvolvedor - 7Cantos

Este repositório contém a solução para o teste de desenvolvedor solicitado pela 7Cantos, que envolve o uso de tecnologias como React e Laravel para criar uma aplicação de gerenciamento de tarefas. O teste foi dividido em duas partes: **Frontend** (React) e **Backend** (Laravel), com questões extras para pontos bônus.

## Descrição do Desafio

O teste é composto por 5 questões principais, além de questões extras para ganhar pontos bônus. O objetivo é testar as habilidades no desenvolvimento web utilizando **React** para o frontend e **Laravel** para o backend.

As questões principais são:
1. Criar uma função React para exibir um array de tarefas.
2. Criar um componente React para adicionar, remover e marcar tarefas como concluídas.
3. Criar um modelo de tarefas no Laravel.
4. Criar um controller no Laravel para exibir as tarefas.
5. Criar uma rota no Laravel para adicionar novas tarefas.

Além disso, os extras incluem a integração com a **API DummyJSON** para simular tarefas e autenticação.

## Tecnologias Utilizadas

- **Frontend**: React.js
- **Backend**: Laravel 10
- **API**: DummyJSON para simular lista de tarefas e login
- **Banco de Dados**: SQLite (para facilitar a configuração local)
- **Outros**: Axios, Bootstrap (ou outra biblioteca de estilização)

## Como Executar o Projeto

Siga os passos abaixo para rodar o projeto localmente:

### Pré-requisitos

- [Node.js](https://nodejs.org/) >= 14
- [Composer](https://getcomposer.org/)
- [PHP](https://www.php.net/) >= 8.1

### Instruções

1. Clone este repositório:
   ```bash
   git clone https://github.com/seu-usuario/teste-7cantos.git
   ```

2. Instale as dependências do backend (Laravel):
```bash
    cd teste-7cantos
    cd backend
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
```
