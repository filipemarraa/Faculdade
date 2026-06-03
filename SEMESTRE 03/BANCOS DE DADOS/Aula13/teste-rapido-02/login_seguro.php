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

$stmt = $conn->prepare("SELECT * FROM usuarios_login WHERE usuario = ? AND senha = ?");
$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "sucesso" => true,
        "usuario" => $row['usuario']
    ]);
} else {
    echo json_encode(["erro" => "Usuário ou senha inválidos. Ataque bloqueado!"]);
}

$stmt->close();
$conn->close();
?>
