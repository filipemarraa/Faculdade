<?php

namespace App\Models;

use App\Core\Database;

class Permissao
{
    public function perfilTemPermissao(string $tipo, string $codigo): bool
    {
        $sql = 'SELECT 1
                FROM tipo_usuario tu
                INNER JOIN tipo_usuario_permissao tup ON tup.id_tipo_usuario = tu.id_tipo_usuario
                INNER JOIN permissao p ON p.id_permissao = tup.id_permissao
                WHERE tu.codigo = :tipo AND p.codigo = :codigo
                LIMIT 1';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute(['tipo' => $tipo, 'codigo' => $codigo]);

        return (bool) $stmt->fetchColumn();
    }
}
