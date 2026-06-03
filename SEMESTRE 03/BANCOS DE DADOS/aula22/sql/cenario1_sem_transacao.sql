-- ============================================================
-- CENÁRIO 1: Sem Transações (Race Condition)
-- Teste Rápido 05 - Aula 22
-- ============================================================

-- Criação do banco e tabela
CREATE DATABASE IF NOT EXISTS escola_bolsa;
USE escola_bolsa;

CREATE TABLE IF NOT EXISTS bolsa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(100),
    saldo DECIMAL(10,2)
);

-- Saldo inicial
INSERT INTO bolsa (descricao, saldo) VALUES ('Bolsa de Pesquisa', 1000.00)
ON DUPLICATE KEY UPDATE saldo = 1000.00;

-- ============================================================
-- SIMULAÇÃO DO PROBLEMA DE CONCORRÊNCIA SEM TRANSAÇÃO
-- Imagine que as duas conexões executam ao mesmo tempo:
-- ============================================================

-- [CONEXÃO A - Aluno A] - Lê o saldo
SELECT saldo FROM bolsa WHERE id = 1;
-- Resultado: 1000.00

-- [CONEXÃO B - Aluno B] - Lê o saldo (AO MESMO TEMPO)
SELECT saldo FROM bolsa WHERE id = 1;
-- Resultado: 1000.00 (leu antes de A atualizar!)

-- [CONEXÃO A] - Aluno A saca R$ 700 com base no que leu (1000)
UPDATE bolsa SET saldo = 1000.00 - 700.00 WHERE id = 1;
-- Saldo agora: 300.00

-- [CONEXÃO B] - Aluno B saca R$ 500 com base no que leu (1000) ← PROBLEMA!
UPDATE bolsa SET saldo = 1000.00 - 500.00 WHERE id = 1;
-- Saldo agora: 500.00 ← ERRADO! Deveria ser 300 - 500 = NEGATIVO (inválido)

-- Resultado final: saldo inconsistente de R$ 500,00
-- O saque de A foi sobrescrito pelo saque de B!
SELECT * FROM bolsa;
