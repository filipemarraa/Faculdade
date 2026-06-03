# Plano de Backup e Restauração

## Objetivo

Garantir continuidade operacional do sistema de hotel em caso de falha, perda de dados, erro humano ou indisponibilidade do servidor.

## Banco protegido

Banco principal:

```text
lab04_hotel_reservas
```

Tabelas críticas:

- `usuario`
- `tipo_usuario`
- `permissao`
- `tipo_usuario_permissao`
- `quarto`
- `reserva`

## Estratégia de backup

Backups recomendados:

- Diário: backup completo do banco após o expediente.
- Antes de alterações: backup manual antes de mudanças estruturais ou carga de dados.
- Semanal: cópia completa armazenada fora da máquina principal.

Comando:

```bash
mysqldump -u root -p \
  --single-transaction \
  --routines \
  --triggers \
  lab04_hotel_reservas > backups/lab04_hotel_reservas_$(date +%Y%m%d_%H%M%S).sql
```

## Armazenamento

Os arquivos devem ser armazenados em:

- Pasta local `backups/` para recuperação rápida.
- Cópia externa em mídia removível ou serviço institucional.
- Retenção mínima de 7 backups diários e 4 backups semanais.

Não armazenar senhas do banco dentro dos arquivos do projeto.

## Restauração

1. Parar uso da aplicação para evitar escrita concorrente.
2. Criar backup de segurança do estado atual, se possível.
3. Recriar ou limpar o banco.
4. Restaurar o dump:

```bash
mysql -u root -p lab04_hotel_reservas < backups/arquivo_de_backup.sql
```

5. Testar login, listagem de quartos, criação de reserva e painel analítico.

## Validação pós-restauração

Executar as verificações:

- Login de administrador.
- Login de gerência.
- Login de usuário comum.
- Listagem de usuários.
- Listagem de quartos.
- Consulta de reservas.
- Acesso ao painel analítico apenas pelo administrador.

## Riscos e mitigação

- Backup corrompido: manter múltiplas cópias e testar restauração periodicamente.
- Exposição de dados sensíveis: restringir acesso aos dumps.
- Perda por erro humano: executar backup antes de alterações de schema.
- Falha de armazenamento local: manter cópia externa.
