CREATE DATABASE IF NOT EXISTS lab04_hotel_reservas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE lab04_hotel_reservas;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS reserva;
DROP TABLE IF EXISTS quarto;
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
    CONSTRAINT fk_tipo_usuario_permissao_tipo
        FOREIGN KEY (id_tipo_usuario)
        REFERENCES tipo_usuario(id_tipo_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_tipo_usuario_permissao_permissao
        FOREIGN KEY (id_permissao)
        REFERENCES permissao(id_permissao)
        ON DELETE CASCADE
);

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    id_tipo_usuario INT NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_tipo
        FOREIGN KEY (id_tipo_usuario)
        REFERENCES tipo_usuario(id_tipo_usuario)
);

CREATE TABLE quarto (
    id_quarto INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) NOT NULL UNIQUE,
    tipo VARCHAR(40) NOT NULL,
    capacidade INT NOT NULL,
    diaria DECIMAL(10,2) NOT NULL,
    status ENUM('disponivel', 'manutencao', 'inativo') NOT NULL DEFAULT 'disponivel',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_quarto_capacidade CHECK (capacidade > 0),
    CONSTRAINT chk_quarto_diaria CHECK (diaria >= 0)
);

CREATE TABLE reserva (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_quarto INT NOT NULL,
    data_checkin DATE NOT NULL,
    data_checkout DATE NOT NULL,
    quantidade_hospedes INT NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    status ENUM('pendente', 'confirmada', 'cancelada', 'concluida') NOT NULL DEFAULT 'pendente',
    observacao VARCHAR(255) NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario),
    CONSTRAINT fk_reserva_quarto
        FOREIGN KEY (id_quarto)
        REFERENCES quarto(id_quarto),
    CONSTRAINT chk_reserva_datas CHECK (data_checkout > data_checkin),
    CONSTRAINT chk_reserva_hospedes CHECK (quantidade_hospedes > 0),
    CONSTRAINT chk_reserva_valor CHECK (valor_total >= 0),
    INDEX idx_reserva_periodo (id_quarto, data_checkin, data_checkout),
    INDEX idx_reserva_usuario (id_usuario),
    INDEX idx_reserva_status (status)
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
('proprio_perfil_editar', 'Editar as proprias informacoes'),
('quarto_gerenciar', 'Cadastrar e editar quartos'),
('quarto_excluir', 'Remover quartos'),
('reserva_criar', 'Criar reservas'),
('reserva_visualizar_todas', 'Visualizar todas as reservas'),
('reserva_gerenciar', 'Gerenciar status de reservas'),
('dashboard_visualizar', 'Visualizar painel analitico administrativo');

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
CROSS JOIN permissao p
WHERE tu.codigo = 'admin';

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
JOIN permissao p ON p.codigo IN (
    'usuario_visualizar',
    'usuario_editar',
    'proprio_perfil_editar',
    'quarto_gerenciar',
    'reserva_visualizar_todas',
    'reserva_gerenciar'
)
WHERE tu.codigo = 'gerencia';

INSERT INTO tipo_usuario_permissao (id_tipo_usuario, id_permissao)
SELECT tu.id_tipo_usuario, p.id_permissao
FROM tipo_usuario tu
JOIN permissao p ON p.codigo IN ('proprio_perfil_editar', 'reserva_criar')
WHERE tu.codigo = 'usuario_comum';

INSERT INTO usuario (nome, email, senha_hash, id_tipo_usuario) VALUES
('Administrador do Sistema', 'admin@hotel.com', '$2y$10$CmIdBPuLtToJ9EESmj5oj.YhFIDvL9axFzwkKNK0g0BK7DFXkMCMu', 1),
('Gerente Operacional', 'gerencia@hotel.com', '$2y$10$CmIdBPuLtToJ9EESmj5oj.YhFIDvL9axFzwkKNK0g0BK7DFXkMCMu', 2),
('Hospede Padrao', 'usuario@hotel.com', '$2y$10$CmIdBPuLtToJ9EESmj5oj.YhFIDvL9axFzwkKNK0g0BK7DFXkMCMu', 3);

INSERT INTO quarto (numero, tipo, capacidade, diaria, status) VALUES
('101', 'Standard', 2, 220.00, 'disponivel'),
('102', 'Standard', 2, 220.00, 'disponivel'),
('201', 'Luxo', 3, 380.00, 'disponivel'),
('202', 'Luxo', 3, 380.00, 'manutencao'),
('301', 'Suite Familia', 5, 620.00, 'disponivel');

INSERT INTO reserva (
    id_usuario,
    id_quarto,
    data_checkin,
    data_checkout,
    quantidade_hospedes,
    valor_total,
    status,
    observacao
) VALUES
(3, 1, '2026-06-10', '2026-06-12', 2, 440.00, 'confirmada', 'Reserva de demonstracao confirmada.'),
(3, 3, '2026-06-18', '2026-06-21', 2, 1140.00, 'pendente', 'Aguardando confirmacao da gerencia.');
