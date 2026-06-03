<?php

namespace App\Models;

use App\Core\Database;
use DateTimeImmutable;
use RuntimeException;

class Reserva
{
    public const STATUS = ['pendente', 'confirmada', 'cancelada', 'concluida'];

    public function all(?int $idUsuario = null): array
    {
        $where = '';
        $params = [];

        if ($idUsuario !== null) {
            $where = 'WHERE r.id_usuario = :id_usuario';
            $params['id_usuario'] = $idUsuario;
        }

        $sql = "SELECT r.id_reserva,
                       r.id_usuario,
                       r.id_quarto,
                       r.data_checkin,
                       r.data_checkout,
                       r.quantidade_hospedes,
                       r.valor_total,
                       r.status,
                       r.observacao,
                       u.nome AS usuario_nome,
                       q.numero AS quarto_numero,
                       q.tipo AS quarto_tipo
                FROM reserva r
                INNER JOIN usuario u ON u.id_usuario = r.id_usuario
                INNER JOIN quarto q ON q.id_quarto = r.id_quarto
                {$where}
                ORDER BY r.data_checkin DESC, r.id_reserva DESC";

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.id_reserva,
                    r.id_usuario,
                    r.id_quarto,
                    r.data_checkin,
                    r.data_checkout,
                    r.quantidade_hospedes,
                    r.valor_total,
                    r.status,
                    r.observacao,
                    u.nome AS usuario_nome,
                    q.numero AS quarto_numero,
                    q.tipo AS quarto_tipo
             FROM reserva r
             INNER JOIN usuario u ON u.id_usuario = r.id_usuario
             INNER JOIN quarto q ON q.id_quarto = r.id_quarto
             WHERE r.id_reserva = :id'
        );
        $stmt->execute(['id' => $id]);
        $reserva = $stmt->fetch();

        return $reserva ?: null;
    }

    public function create(array $data): void
    {
        $quarto = (new Quarto())->find((int) $data['id_quarto']);
        if (!$quarto) {
            throw new RuntimeException('Quarto não encontrado.');
        }

        if ($quarto['status'] !== 'disponivel') {
            throw new RuntimeException('Este quarto não está disponível para reservas.');
        }

        if ((int) $data['quantidade_hospedes'] > (int) $quarto['capacidade']) {
            throw new RuntimeException('A quantidade de hóspedes excede a capacidade do quarto.');
        }

        $diarias = $this->calcularDiarias($data['data_checkin'], $data['data_checkout']);
        if ($this->periodoIndisponivel((int) $data['id_quarto'], $data['data_checkin'], $data['data_checkout'])) {
            throw new RuntimeException('Já existe reserva ativa para este quarto no período informado.');
        }

        $stmt = Database::getConnection()->prepare(
            'INSERT INTO reserva (
                 id_usuario,
                 id_quarto,
                 data_checkin,
                 data_checkout,
                 quantidade_hospedes,
                 valor_total,
                 status,
                 observacao
             ) VALUES (
                 :id_usuario,
                 :id_quarto,
                 :data_checkin,
                 :data_checkout,
                 :quantidade_hospedes,
                 :valor_total,
                 :status,
                 :observacao
             )'
        );

        $stmt->execute([
            'id_usuario' => (int) $data['id_usuario'],
            'id_quarto' => (int) $data['id_quarto'],
            'data_checkin' => $data['data_checkin'],
            'data_checkout' => $data['data_checkout'],
            'quantidade_hospedes' => (int) $data['quantidade_hospedes'],
            'valor_total' => $diarias * (float) $quarto['diaria'],
            'status' => 'pendente',
            'observacao' => trim($data['observacao'] ?? ''),
        ]);
    }

    public function updateStatus(int $id, string $status): void
    {
        if (!in_array($status, self::STATUS, true)) {
            throw new RuntimeException('Status de reserva inválido.');
        }

        $stmt = Database::getConnection()->prepare(
            'UPDATE reserva SET status = :status WHERE id_reserva = :id'
        );
        $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM reserva WHERE id_reserva = :id');
        $stmt->execute(['id' => $id]);
    }

    public function calcularDiarias(string $checkin, string $checkout): int
    {
        $inicio = DateTimeImmutable::createFromFormat('Y-m-d', $checkin);
        $fim = DateTimeImmutable::createFromFormat('Y-m-d', $checkout);

        if (!$inicio || !$fim || $fim <= $inicio) {
            throw new RuntimeException('O check-out deve ser posterior ao check-in.');
        }

        return (int) $inicio->diff($fim)->days;
    }

    private function periodoIndisponivel(int $idQuarto, string $checkin, string $checkout): bool
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*)
             FROM reserva
             WHERE id_quarto = :id_quarto
               AND status IN ('pendente', 'confirmada')
               AND data_checkin < :checkout
               AND data_checkout > :checkin"
        );
        $stmt->execute([
            'id_quarto' => $idQuarto,
            'checkin' => $checkin,
            'checkout' => $checkout,
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}
