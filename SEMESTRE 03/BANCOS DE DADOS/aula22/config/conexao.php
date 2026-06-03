<?php
$conn = new mysqli("localhost", "root", "", "escola_bolsa");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}
