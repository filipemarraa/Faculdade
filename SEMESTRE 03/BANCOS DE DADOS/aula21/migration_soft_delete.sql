-- Adiciona a coluna de Soft Delete na tabela usuarios
-- Execute este script no seu banco de dados "cadastro"

ALTER TABLE usuarios
    ADD COLUMN deleted_at DATETIME DEFAULT NULL;

-- Verificar a estrutura atualizada
DESCRIBE usuarios;
