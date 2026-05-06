<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "cadastro");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

$nome       = $_POST['nome'] ?? '';
$email      = $_POST['email'] ?? '';
$nascimento = $_POST['nascimento'] ?? '';

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, nascimento) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $nascimento);

if ($stmt->execute()) {
    echo json_encode(["sucesso" => true]);
} else {
    echo json_encode(["erro" => "Erro ao cadastrar usuário"]);
}

$stmt->close();
$conn->close();
?>
