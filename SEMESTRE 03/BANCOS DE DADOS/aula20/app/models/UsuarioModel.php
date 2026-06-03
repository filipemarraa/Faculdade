<?php
require_once __DIR__ . '/../../config/conexao.php';

class UsuarioModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listarUsuarios() {
        $result = $this->conn->query("SELECT * FROM usuarios");
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
            "UPDATE usuarios SET nome=?, email=?, nascimento=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $nome, $email, $nascimento, $id);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }

    public function excluirUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $sucesso = $stmt->execute();
        $stmt->close();
        return $sucesso;
    }
}
