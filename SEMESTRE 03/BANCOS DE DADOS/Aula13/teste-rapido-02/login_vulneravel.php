<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("db", "root", "", "demo_seguranca");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

$usuario = $_POST['usuario'] ?? '';
$senha   = $_POST['senha']   ?? '';

// ❌ VULNERÁVEL: concatenação direta de variáveis no SQL
// Permite SQL Injection — ex: usuario = ' OR '1'='1' --
$sql = "SELECT * FROM usuarios_login WHERE usuario = '$usuario' AND senha = '$senha'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "sucesso" => true,
        "usuario" => $row['usuario'],
        "sql"     => $sql // retorna o SQL para fins didáticos
    ]);
} else {
    echo json_encode(["erro" => "Usuário ou senha inválidos."]);
}

$conn->close();
?>
