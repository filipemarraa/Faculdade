<?php

namespace App\Core;

use App\Models\Permissao;

class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['usuario'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function login(array $usuario): void
    {
        $_SESSION['usuario'] = [
            'id_usuario' => (int) $usuario['id_usuario'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'tipo' => $usuario['tipo'],
            'tipo_descricao' => $usuario['tipo_descricao'],
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function isAdmin(): bool
    {
        return (self::user()['tipo'] ?? '') === 'admin';
    }

    public static function isGerencia(): bool
    {
        return (self::user()['tipo'] ?? '') === 'gerencia';
    }

    public static function isUsuarioComum(): bool
    {
        return (self::user()['tipo'] ?? '') === 'usuario_comum';
    }

    public static function temPermissao(string $permissao): bool
    {
        $usuario = self::user();
        if (!$usuario) {
            return false;
        }

        $permissoes = new Permissao();
        return $permissoes->perfilTemPermissao($usuario['tipo'], $permissao);
    }
}
