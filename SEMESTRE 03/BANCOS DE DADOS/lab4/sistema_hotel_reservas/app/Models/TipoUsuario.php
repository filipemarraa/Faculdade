<?php

namespace App\Models;

use App\Core\Database;

class TipoUsuario
{
    public function all(): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id_tipo_usuario, codigo, descricao FROM tipo_usuario ORDER BY id_tipo_usuario'
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id_tipo_usuario, codigo, descricao FROM tipo_usuario WHERE id_tipo_usuario = :id'
        );
        $stmt->execute(['id' => $id]);
        $tipo = $stmt->fetch();

        return $tipo ?: null;
    }
}
