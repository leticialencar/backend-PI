<?php
require __DIR__ . '/../../config/config.php';
$conn = Conexao::getConn();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['percentual']) || !is_numeric($data['percentual'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Percentual inválido']);
    exit;
}

$percentual = floatval($data['percentual']);

try {
    $sql = "UPDATE funcionario SET salario = salario * (1 + :percentual / 100)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':percentual', $percentual);
    $stmt->execute();

    echo json_encode(['sucesso' => true, 'mensagem' => 'Reajuste aplicado com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao aplicar reajuste: ' . $e->getMessage()]);
}
