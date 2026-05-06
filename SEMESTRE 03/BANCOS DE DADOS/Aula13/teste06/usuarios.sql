CREATE DATABASE IF NOT EXISTS cadastro;

USE cadastro;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    nascimento DATE
);
