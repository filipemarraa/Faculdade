CREATE DATABASE IF NOT EXISTS lab03_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE lab03_usuarios;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS tipo_usuario_permissao;
DROP TABLE IF EXISTS permissao;
DROP TABLE IF EXISTS tipo_usuario;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tipo_usuario (
    id_tipo_usuario INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(30) NOT NULL UNIQUE,
    descricao VARCHAR(80) NOT NULL
);

CREATE TABLE permissao (
    id_permissao INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(60) NOT NULL UNIQUE,
    descricao VARCHAR(150) NOT NULL
);

CREATE TABLE tipo_usuario_permissao (
    id_tipo_usuario INT NOT NULL,
    id_permissao INT NOT NULL,
    PRIMARY KEY (id_tipo_usuario, id_permissao),
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuario(id_tipo_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_permissao) REFERENCES permissao(id_permissao) ON DELETE CASCADE
);

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    id_tipo_usuario INT NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuario(id_tipo_usuario)
);

INSERT INTO tipo_usuario (codigo, descricao) VALUES
('admin', 'Administrador'),
('gerencia', 'Gerencia'),
('usuario_comum', 'Usuario comum');

INSERT INTO permissao (codigo, descricao) VALUES
('usuario_criar', 'Cadastrar usuarios'),
('usuario_visualizar', 'Visualizar usuarios cadastrados'),
('usuario_editar', 'Editar usuarios'),
('usuario_excluir', 'Remover usuarios'),
('perfil_alterar', 'Definir e alterar perfis de acesso'),
('proprio_perfil_editar', 'Editar as proprias informacoes');

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
CROSS JOIN permissao p
WHERE tu.codigo = 'admin';

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
JOIN permissao p ON p.codigo IN ('usuario_visualizar', 'usuario_editar', 'proprio_perfil_editar')
WHERE tu.codigo = 'gerencia';

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
JOIN permissao p ON p.codigo = 'proprio_perfil_editar'
WHERE tu.codigo = 'usuario_comum';

INSERT INTO usuario (nome, email, senha_hash, id_tipo_usuario) VALUES
('Administrador do Sistema', 'admin@hotel.com', '$2y$10$woCTDjolmVcutBgMEApiUu.L2PKG1ZTwDpyG6WojVRfEgwFF4CWDa', 1),
('Gerente Operacional', 'gerencia@hotel.com', '$2y$10$woCTDjolmVcutBgMEApiUu.L2PKG1ZTwDpyG6WojVRfEgwFF4CWDa', 2),
('Usuario Comum', 'usuario@hotel.com', '$2y$10$woCTDjolmVcutBgMEApiUu.L2PKG1ZTwDpyG6WojVRfEgwFF4CWDa', 3);
