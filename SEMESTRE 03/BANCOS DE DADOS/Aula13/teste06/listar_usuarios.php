<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "cadastro");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

$conn->close();
?>
