<?php
session_start();
include __DIR__ . '/../../config/config.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['id'] ?? null;

if (!$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de usuário inválido.']);
    exit;
}

try {
    $conn = Conexao::getConn();
    $stmt = $conn->prepare("UPDATE USUARIO SET ativo = 0 WHERE id_usuario = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao desativar usuário.']);
}
