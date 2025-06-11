<?php
include __DIR__ . '/../../config/config.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_usuario'])) {
        throw new Exception('Dados inválidos.');
    }

    $conn = Conexao::getConn();

    // Monta nome completo
    $nome_usuario = trim($data['nome'] . ' ' . $data['sobrenome']);

    // Atualiza dados principais
    $sql = "UPDATE USUARIO SET 
        nome_usuario = :nome_usuario,
        cpf_usuario = :cpf,
        email_usuario = :email,
        id_cargo = :id_cargo
        WHERE id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome_usuario', $nome_usuario);
    $stmt->bindParam(':cpf', $data['cpf']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':id_cargo', $data['cargo']);
    $stmt->bindParam(':id_usuario', $data['id_usuario']);
    $stmt->execute();

    // Atualiza senha se informada
    if (!empty($data['senha'])) {
        if ($data['senha'] !== $data['repetir_senha']) {
            throw new Exception('As senhas não coincidem.');
        }
        $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE USUARIO SET senha_usuario = :senha WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id_usuario', $data['id_usuario']);
        $stmt->execute();
    }

    echo json_encode(['success' => true, 'message' => 'Usuário alterado com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
