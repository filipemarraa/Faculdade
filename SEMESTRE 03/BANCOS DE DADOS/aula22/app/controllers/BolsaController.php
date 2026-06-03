<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../app/models/BolsaModel.php';

$model = new BolsaModel($conn);
$acao  = $_GET['acao'] ?? '';

switch ($acao) {
    case 'saldo':
        echo json_encode(["saldo" => $model->getSaldo()]);
        break;

    case 'sacarSemTransacao':
        $aluno = $_POST['aluno'] ?? '';
        $valor = (float)($_POST['valor'] ?? 0);
        echo json_encode($model->sacarSemTransacao($aluno, $valor));
        break;

    case 'sacarComTransacao':
        $aluno = $_POST['aluno'] ?? '';
        $valor = (float)($_POST['valor'] ?? 0);
        echo json_encode($model->sacarComTransacao($aluno, $valor));
        break;

    case 'reset':
        echo json_encode(["saldo" => $model->resetSaldo()]);
        break;

    default:
        echo json_encode(["erro" => "Ação inválida"]);
}

$conn->close();
