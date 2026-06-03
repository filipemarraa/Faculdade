-- Banco de dados para demonstração de SQL Injection vs Prepared Statements
CREATE DATABASE IF NOT EXISTS demo_seguranca;

USE demo_seguranca;

DROP TABLE IF EXISTS usuarios_login;

CREATE TABLE usuarios_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL
);

-- Usuários de exemplo
INSERT INTO usuarios_login (usuario, senha) VALUES
    ('admin', 'senha123'),
    ('filipe', 'minha_senha'),
    ('professor', 'aula18');
