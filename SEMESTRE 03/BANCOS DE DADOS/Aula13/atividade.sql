CREATE TABLE treinamento_geral (
    id_registro SERIAL PRIMARY KEY,
    nome_funcionario VARCHAR(150),
    cpf VARCHAR(14),
    departamento VARCHAR(100),
    nome_curso VARCHAR(150),
    carga_horaria INT,
    nome_instrutor VARCHAR(150),
    email_instrutor VARCHAR(150),
    data_inicio DATE,
    data_fim DATE,
    sala VARCHAR(50),
    telefones_funcionario TEXT,
    certificados TEXT
);