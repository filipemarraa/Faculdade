-- ============================================================
-- CENÁRIO 2: Com Transações e SELECT ... FOR UPDATE
-- Teste Rápido 05 - Aula 22
-- ============================================================

USE escola_bolsa;

-- Redefine o saldo inicial
UPDATE bolsa SET saldo = 1000.00 WHERE id = 1;

-- ============================================================
-- SIMULAÇÃO COM CONTROLE DE CONCORRÊNCIA
-- ============================================================

-- ── TRANSAÇÃO A (Aluno A - R$ 700) ──────────────────────────

START TRANSACTION;

-- SELECT ... FOR UPDATE: bloqueia a linha para escrita exclusiva
-- A Transação B ficará aguardando aqui até A fazer COMMIT
SELECT saldo FROM bolsa WHERE id = 1 FOR UPDATE;
-- Saldo lido: 1000.00

-- Verifica se há saldo suficiente (1000 >= 700 ✓)
UPDATE bolsa SET saldo = saldo - 700.00 WHERE id = 1;

COMMIT;
-- Saldo após A: 300.00 — lock liberado

-- ── TRANSAÇÃO B (Aluno B - R$ 500) ──────────────────────────
-- (B estava aguardando o lock de A ser liberado)

START TRANSACTION;

-- Agora B lê o valor ATUALIZADO após o COMMIT de A
SELECT saldo FROM bolsa WHERE id = 1 FOR UPDATE;
-- Saldo lido: 300.00

-- Verifica se há saldo suficiente (300 < 500 ✗ — saque negado!)
-- A aplicação detecta e faz ROLLBACK
ROLLBACK;
-- Saldo permanece: 300.00

-- Resultado final correto: R$ 300,00
-- Apenas o saque de A foi realizado; B foi bloqueado por saldo insuficiente
SELECT * FROM bolsa;
