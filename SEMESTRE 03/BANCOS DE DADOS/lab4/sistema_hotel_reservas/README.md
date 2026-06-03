# Lab 4 - Sistema de Hotel e Reservas

## Objetivo

Este projeto implementa a entrega do Laboratório 4 da disciplina de Banco de Dados. A aplicação simula um sistema de hotel em que usuários autenticados podem interagir com quartos e reservas conforme seu perfil de acesso.

O sistema resolve o problema de organizar reservas de hospedagem com controle de permissões, persistência em banco relacional, operações CRUD, painel gerencial e estratégia documentada de backup/restauração.

## Como funciona

A aplicação usa PHP com arquitetura MVC simples:

- `Model`: acessa o banco via PDO e Prepared Statements.
- `View`: renderiza as telas HTML.
- `Controller`: valida entrada, aplica regras de acesso e coordena models/views.

Perfis disponíveis:

- Administrador: acesso completo, incluindo exclusões e painel analítico.
- Gerência: gerencia quartos e reservas, sem excluir registros críticos.
- Usuário comum: cria reservas e visualiza seus próprios dados.

## Funcionalidades

- Login com senha armazenada por hash.
- CRUD de usuários com perfis de acesso.
- CRUD de quartos com restrição de exclusão para administrador.
- Criação e acompanhamento de reservas.
- Gerenciamento de status de reservas por administrador/gerência.
- Painel analítico restrito a administradores.
- Consultas SQL com Prepared Statements.
- Proteção CSRF básica nos formulários de alteração.
- Plano de backup e restauração documentado.

## Stack

- PHP 8+
- MySQL 8+
- PDO
- HTML5
- CSS3

## Setup

1. Crie o banco e as tabelas:

```bash
mysql -u root -p < database/SQL_lab04_hotel_reservas.sql
```

2. Configure as variáveis de ambiente, se necessário:

```bash
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_DATABASE=lab04_hotel_reservas
export DB_USER=root
export DB_PASSWORD=senha_do_mysql
```

3. Inicie o servidor PHP a partir da raiz do projeto:

```bash
php -S localhost:8000 -t public
```

4. Acesse:

```text
http://localhost:8000
```

## Credenciais de demonstração

Os usuários abaixo são criados pelo script SQL. A senha de demonstração para todos é `123456`.

| Perfil | E-mail |
| --- | --- |
| Administrador | `admin@hotel.com` |
| Gerência | `gerencia@hotel.com` |
| Usuário comum | `usuario@hotel.com` |

## Estrutura

```text
app/
  Controllers/
  Core/
  Models/
  Views/
config/
database/
docs/
public/
```

## Arquitetura

O roteamento é centralizado em `public/index.php`. Cada rota aponta para um controller específico. Os controllers exigem login quando necessário, validam permissões via `App\Core\Auth` e delegam a persistência para models.

As regras de negócio de reserva ficam em `App\Models\Reserva`, incluindo cálculo de diárias, verificação de capacidade, bloqueio de quarto indisponível e prevenção de conflito de período.

## Decisões técnicas

- PDO com `ATTR_EMULATE_PREPARES = false` para reduzir risco de SQL Injection.
- Senhas com `password_hash` e validação com `password_verify`.
- Exclusões feitas por POST com token CSRF.
- Administrador é o único perfil com permissão de exclusão ampla.
- Reservas `pendente` e `confirmada` bloqueiam conflito de datas no mesmo quarto.
- O painel analítico fica restrito ao perfil administrador.

## Segurança

Pontos implementados:

- Prepared Statements em todas as consultas com entrada externa.
- Hash seguro de senha.
- Controle de acesso por perfil.
- Proteção CSRF básica em formulários mutáveis.
- Escape de saída com `htmlspecialchars`.
- Exclusão de registros por POST.

Riscos restantes:

- Não há rate limiting no login.
- Não há política avançada de sessão, como renovação de ID após login.
- O projeto é acadêmico e não inclui logs de auditoria.

## Documentos de apoio

- Plano de backup/restauração: `docs/PLANO_BACKUP_RESTAURACAO.md`
- Roteiro de apresentação: `docs/ROTEIRO_APRESENTACAO.md`
