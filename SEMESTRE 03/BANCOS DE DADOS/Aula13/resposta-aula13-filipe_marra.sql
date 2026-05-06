CREATE TABLE funcionario (
    cpf          VARCHAR(14) PRIMARY KEY,
    nome         VARCHAR(150) NOT NULL,
    departamento VARCHAR(100)
);

CREATE TABLE telefone_funcionario (
    id              SERIAL PRIMARY KEY,
    cpf_funcionario VARCHAR(14) NOT NULL REFERENCES funcionario(cpf),
    telefone        VARCHAR(20) NOT NULL
);

CREATE TABLE instrutor (
    id_instrutor SERIAL PRIMARY KEY,
    nome         VARCHAR(150) NOT NULL,
    email        VARCHAR(150)
);

CREATE TABLE curso (
    id_curso      SERIAL PRIMARY KEY,
    nome_curso    VARCHAR(150) NOT NULL,
    carga_horaria INT
);

CREATE TABLE curso_instrutor (
    id_curso     INT REFERENCES curso(id_curso),
    id_instrutor INT REFERENCES instrutor(id_instrutor),
    PRIMARY KEY (id_curso, id_instrutor)
);

CREATE TABLE turma (
    id_turma   SERIAL PRIMARY KEY,
    id_curso   INT  NOT NULL REFERENCES curso(id_curso),
    data_inicio DATE,
    data_fim    DATE,
    sala        VARCHAR(50)
);

CREATE TABLE inscricao_treinamento (
    id              SERIAL PRIMARY KEY,
    cpf_funcionario VARCHAR(14) NOT NULL REFERENCES funcionario(cpf),
    id_turma        INT         NOT NULL REFERENCES turma(id_turma)
);

CREATE TABLE certificado (
    id               SERIAL PRIMARY KEY,
    cpf_funcionario  VARCHAR(14) NOT NULL REFERENCES funcionario(cpf),
    id_turma         INT         NOT NULL REFERENCES turma(id_turma),
    nome_certificado VARCHAR(150),
    data_emissao     DATE
);