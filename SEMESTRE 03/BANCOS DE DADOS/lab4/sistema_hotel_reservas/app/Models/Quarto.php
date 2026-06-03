<?php

namespace App\Models;

use App\Core\Database;

class Quarto
{
    public const STATUS = ['disponivel', 'manutencao', 'inativo'];

    public function all(): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id_quarto, numero, tipo, capacidade, diaria, status
             FROM quarto
             ORDER BY numero'
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function disponiveis(): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT id_quarto, numero, tipo, capacidade, diaria, status
             FROM quarto
             WHERE status = 'disponivel'
             ORDER BY numero"
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id_quarto, numero, tipo, capacidade, diaria, status
             FROM quarto
             WHERE id_quarto = :id'
        );
        $stmt->execute(['id' => $id]);
        $quarto = $stmt->fetch();

        return $quarto ?: null;
    }

    public function create(array $data): void
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO quarto (numero, tipo, capacidade, diaria, status)
             VALUES (:numero, :tipo, :capacidade, :diaria, :status)'
        );
        $stmt->execute($this->params($data));
    }

    public function update(int $id, array $data): void
    {
        $params = $this->params($data);
        $params['id'] = $id;

        $stmt = Database::getConnection()->prepare(
            'UPDATE quarto
             SET numero = :numero,
                 tipo = :tipo,
                 capacidade = :capacidade,
                 diaria = :diaria,
                 status = :status
             WHERE id_quarto = :id'
        );
        $stmt->execute($params);
    }

    public function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM quarto WHERE id_quarto = :id');
        $stmt->execute(['id' => $id]);
    }

    public function possuiReservas(int $id): bool
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*) FROM reserva WHERE id_quarto = :id'
        );
        $stmt->execute(['id' => $id]);

        return (int) $stmt->fetchColumn() > 0;
    }

    private function params(array $data): array
    {
        return [
            'numero' => trim($data['numero'] ?? ''),
            'tipo' => trim($data['tipo'] ?? ''),
            'capacidade' => (int) ($data['capacidade'] ?? 0),
            'diaria' => (float) ($data['diaria'] ?? 0),
            'status' => $data['status'] ?? 'disponivel',
        ];
    }
}
