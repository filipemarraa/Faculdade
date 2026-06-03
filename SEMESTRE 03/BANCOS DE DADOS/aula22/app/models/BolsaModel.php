<?php
require_once __DIR__ . '/../../config/conexao.php';

class BolsaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getSaldo() {
        $result = $this->conn->query("SELECT saldo FROM bolsa WHERE id = 1");
        $row = $result->fetch_assoc();
        return $row ? (float)$row['saldo'] : null;
    }

    // ── CENÁRIO 1: Sem transação (sujeito a race condition) ──────────────────
    public function sacarSemTransacao($aluno, $valor) {
        $saldo = $this->getSaldo();

        if ($saldo === null) {
            return ["sucesso" => false, "erro" => "Bolsa não encontrada"];
        }

        // Sem lock: outro processo pode alterar o saldo entre o SELECT e o UPDATE
        if ($saldo < $valor) {
            return ["sucesso" => false, "erro" => "Saldo insuficiente (lido: R$ {$saldo})"];
        }

        $novoSaldo = $saldo - $valor;
        $this->conn->query("UPDATE bolsa SET saldo = {$novoSaldo} WHERE id = 1");

        return [
            "sucesso"    => true,
            "aluno"      => $aluno,
            "valor"      => $valor,
            "saldo_lido" => $saldo,
            "saldo_final"=> $novoSaldo,
            "aviso"      => "Sem transação: sujeito a race condition!"
        ];
    }

    // ── CENÁRIO 2: Com transação e SELECT ... FOR UPDATE ──────────────────────
    public function sacarComTransacao($aluno, $valor) {
        $this->conn->begin_transaction();

        try {
            // FOR UPDATE bloqueia a linha — outras transações aguardam
            $result = $this->conn->query("SELECT saldo FROM bolsa WHERE id = 1 FOR UPDATE");
            $row = $result->fetch_assoc();
            $saldo = (float)$row['saldo'];

            if ($saldo < $valor) {
                $this->conn->rollback();
                return [
                    "sucesso"    => false,
                    "aluno"      => $aluno,
                    "valor"      => $valor,
                    "saldo_lido" => $saldo,
                    "erro"       => "Saldo insuficiente — ROLLBACK executado",
                    "sql"        => "ROLLBACK"
                ];
            }

            $novoSaldo = $saldo - $valor;
            $this->conn->query("UPDATE bolsa SET saldo = {$novoSaldo} WHERE id = 1");
            $this->conn->commit();

            return [
                "sucesso"    => true,
                "aluno"      => $aluno,
                "valor"      => $valor,
                "saldo_lido" => $saldo,
                "saldo_final"=> $novoSaldo,
                "sql"        => "COMMIT"
            ];

        } catch (Exception $e) {
            $this->conn->rollback();
            return ["sucesso" => false, "erro" => $e->getMessage(), "sql" => "ROLLBACK"];
        }
    }

    public function resetSaldo() {
        $this->conn->query("UPDATE bolsa SET saldo = 1000.00 WHERE id = 1");
        return $this->getSaldo();
    }
}
