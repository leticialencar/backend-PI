<?php
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataConta = $_POST['data-conta'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $variado = $_POST['variado'] ?? null;
    $valor = $_POST['valor'] ?? null;

    $dataPagamento = $dataConta;

    header('Content-Type: application/json'); 

    if ($dataConta && $descricao && $valor && $variado) {
        try {
            $conn = Conexao::getConn();
            $stmt = $conn->prepare("
                INSERT INTO DESPESA_VARIADOS (data_conta, data_pagamento, descricao, valor, variado)
                VALUES (:data_conta, :data_pagamento, :descricao, :valor, :variado)
            ");

            $stmt->bindParam(':data_conta', $dataConta);
            $stmt->bindParam(':data_pagamento', $dataPagamento);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':variado', $variado);

            $stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'Despesa Variada salva com sucesso!']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar no banco: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Requisição inválida.']);
}
?>
