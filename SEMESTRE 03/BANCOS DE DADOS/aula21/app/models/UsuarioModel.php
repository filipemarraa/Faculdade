<?php
require_once __DIR__ . '/../../config/conexao.php';

class UsuarioModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Retorna apenas usuários NÃO deletados (Soft Delete)
    public function listarUsuarios() {
        $result = $this->conn->query("SELECT * FROM usuarios WHERE deleted_at IS NULL");
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    // Retorna usuários que foram deletados (para exibir na lixeira)
    public function listarDeletados() {
        $result = $this->conn->query("SELECT * FROM usuarios WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    public function salvarUsuario($nome, $email, $nascimento) {
        $stmt = $this->conn->prepare(
            "INSERT INTO usuarios (nome, email, nascimento) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $nome, $email, $nascimento);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }

    public function editarUsuario($id, $nome, $email, $nascimento) {
        $stmt = $this->conn->prepare(
            "UPDATE usuarios SET nome=?, email=?, nascimento=? WHERE id=? AND deleted_at IS NULL"
        );
        $stmt->bind_param("sssi", $nome, $email, $nascimento, $id);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }

    // Soft Delete: marca deleted_at em vez de remover o registro
    public function excluirUsuario($id) {
        $stmt = $this->conn->prepare(
            "UPDATE usuarios SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL"
        );
        $stmt->bind_param("i", $id);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }

    // Restaura um usuário deletado
    public function restaurarUsuario($id) {
        $stmt = $this->conn->prepare(
            "UPDATE usuarios SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL"
        );
        $stmt->bind_param("i", $id);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }
}
