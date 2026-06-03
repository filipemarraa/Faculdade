<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../app/models/UsuarioModel.php';

$model = new UsuarioModel($conn);
$acao = $_GET['acao'] ?? '';

switch ($acao) {
    case 'listar':
        echo json_encode($model->listarUsuarios());
        break;

    case 'listarDeletados':
        echo json_encode($model->listarDeletados());
        break;

    case 'salvar':
        $nome       = $_POST['nome']       ?? '';
        $email      = $_POST['email']      ?? '';
        $nascimento = $_POST['nascimento'] ?? '';
        if ($model->salvarUsuario($nome, $email, $nascimento)) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao salvar usuário"]);
        }
        break;

    case 'editar':
        $id         = $_POST['id']         ?? 0;
        $nome       = $_POST['nome']       ?? '';
        $email      = $_POST['email']      ?? '';
        $nascimento = $_POST['nascimento'] ?? '';
        if ($model->editarUsuario($id, $nome, $email, $nascimento)) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao editar usuário"]);
        }
        break;

    // Soft Delete: não apaga, apenas marca deleted_at
    case 'excluir':
        $id = $_POST['id'] ?? 0;
        if ($model->excluirUsuario($id)) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao excluir usuário"]);
        }
        break;

    // Restaura usuário que estava com soft delete
    case 'restaurar':
        $id = $_POST['id'] ?? 0;
        if ($model->restaurarUsuario($id)) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao restaurar usuário"]);
        }
        break;

    default:
        echo json_encode(["erro" => "Ação inválida"]);
}

$conn->close();
