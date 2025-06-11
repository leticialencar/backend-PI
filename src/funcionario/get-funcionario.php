<?php
require '/../../config/config.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'ID não fornecido']);
    exit;
}

$id = $_GET['id'];

$conn = Conexao::getConn();
$stmt = $conn->prepare("SELECT * FROM FUNCIONARIO WHERE id_funcionario = ?");
$stmt->execute([$id]);
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    http_response_code(404);
    echo json_encode(['erro' => 'Funcionário não encontrado']);
    exit;
}

echo json_encode($funcionario);
