# Roteiro de Apresentação

Tempo sugerido: 10 minutos de demonstração e 5 minutos para perguntas.

## 1. Objetivo do sistema

Apresentar o sistema como uma aplicação de hotel que controla usuários, quartos e reservas com perfis de acesso.

## 2. Interface inicial

Mostrar login e painel inicial.

## 3. Perfis de acesso

Demonstrar:

- Administrador com acesso completo.
- Gerência com acesso operacional.
- Usuário comum com acesso restrito às próprias reservas.

## 4. CRUD de usuários

Com administrador:

- Listar usuários.
- Cadastrar usuário.
- Editar usuário.
- Demonstrar que exclusão é restrita ao administrador.

## 5. CRUD de quartos

Com administrador ou gerência:

- Listar quartos.
- Cadastrar quarto.
- Editar status ou diária.
- Demonstrar bloqueio de exclusão quando houver reservas vinculadas.

## 6. Rotina de negócio

Com usuário comum:

- Criar uma reserva.
- Selecionar quarto disponível.
- Informar check-in, check-out e quantidade de hóspedes.
- Mostrar que o sistema calcula o valor total.

Com gerência:

- Visualizar todas as reservas.
- Alterar status para `confirmada`, `cancelada` ou `concluida`.

## 7. Painel analítico

Com administrador:

- Mostrar total de usuários, quartos, reservas e receita confirmada.
- Mostrar reservas por status.
- Mostrar ocupação por quarto.

## 8. Backup e restauração

Apresentar o arquivo `docs/PLANO_BACKUP_RESTAURACAO.md` e explicar:

- periodicidade;
- comando de backup;
- armazenamento;
- processo de restauração;
- validação após recuperação.
