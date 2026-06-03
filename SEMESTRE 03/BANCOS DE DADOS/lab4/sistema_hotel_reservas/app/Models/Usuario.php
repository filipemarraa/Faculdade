<?php

namespace App\Models;

use App\Core\Database;

class Usuario
{
    public function authenticate(string $email, string $senha): ?array
    {
        $sql = 'SELECT u.*, tu.codigo AS tipo, tu.descricao AS tipo_descricao
                FROM usuario u
                INNER JOIN tipo_usuario tu ON tu.id_tipo_usuario = u.id_tipo_usuario
                WHERE u.email = :email
                LIMIT 1';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
            return null;
        }

        return $usuario;
    }

    public function all(): array
    {
        $sql = 'SELECT u.id_usuario, u.nome, u.email,
                       tu.codigo AS tipo, tu.descricao AS tipo_descricao
                FROM usuario u
                INNER JOIN tipo_usuario tu ON tu.id_tipo_usuario = u.id_tipo_usuario
                ORDER BY u.nome';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $sql = 'SELECT u.id_usuario, u.nome, u.email, u.id_tipo_usuario,
                       tu.codigo AS tipo, tu.descricao AS tipo_descricao
                FROM usuario u
                INNER JOIN tipo_usuario tu ON tu.id_tipo_usuario = u.id_tipo_usuario
                WHERE u.id_usuario = :id';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    public function create(array $data): void
    {
        $sql = 'INSERT INTO usuario
                    (nome, email, senha_hash, id_tipo_usuario)
                VALUES
                    (:nome, :email, :senha_hash, :id_tipo_usuario)';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha_hash' => password_hash($data['senha'], PASSWORD_DEFAULT),
            'id_tipo_usuario' => (int) $data['id_tipo_usuario'],
        ]);
    }

    public function update(int $id, array $data, bool $updatePerfil = true): void
    {
        $fields = 'nome = :nome, email = :email';
        $params = [
            'id' => $id,
            'nome' => $data['nome'],
            'email' => $data['email'],
        ];

        if ($updatePerfil) {
            $fields .= ', id_tipo_usuario = :id_tipo_usuario';
            $params['id_tipo_usuario'] = (int) $data['id_tipo_usuario'];
        }

        if (!empty($data['senha'])) {
            $fields .= ', senha_hash = :senha_hash';
            $params['senha_hash'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        $stmt = Database::getConnection()->prepare("UPDATE usuario SET {$fields} WHERE id_usuario = :id");
        $stmt->execute($params);
    }

    public function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM usuario WHERE id_usuario = :id');
        $stmt->execute(['id' => $id]);
    }
}
