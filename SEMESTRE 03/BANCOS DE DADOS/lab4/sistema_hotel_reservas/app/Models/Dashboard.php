<?php

namespace App\Models;

use App\Core\Database;

class Dashboard
{
    public function indicadores(): array
    {
        return [
            'usuarios' => $this->contar('usuario'),
            'quartos' => $this->contar('quarto'),
            'reservas' => $this->contar('reserva'),
            'receita' => $this->receitaConfirmada(),
            'reservasPorStatus' => $this->reservasPorStatus(),
            'ocupacaoPorQuarto' => $this->ocupacaoPorQuarto(),
        ];
    }

    private function contar(string $tabela): int
    {
        $tabelasPermitidas = ['usuario', 'quarto', 'reserva'];
        if (!in_array($tabela, $tabelasPermitidas, true)) {
            return 0;
        }

        $stmt = Database::getConnection()->prepare("SELECT COUNT(*) FROM {$tabela}");
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    private function receitaConfirmada(): float
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COALESCE(SUM(valor_total), 0)
             FROM reserva
             WHERE status IN ('confirmada', 'concluida')"
        );
        $stmt->execute();

        return (float) $stmt->fetchColumn();
    }

    private function reservasPorStatus(): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT status, COUNT(*) AS total
             FROM reserva
             GROUP BY status
             ORDER BY status'
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function ocupacaoPorQuarto(): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT q.numero,
                    q.tipo,
                    q.status,
                    COUNT(r.id_reserva) AS reservas_ativas
             FROM quarto q
             LEFT JOIN reserva r
                    ON r.id_quarto = q.id_quarto
                   AND r.status IN ('pendente', 'confirmada')
             GROUP BY q.id_quarto, q.numero, q.tipo, q.status
             ORDER BY q.numero"
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
