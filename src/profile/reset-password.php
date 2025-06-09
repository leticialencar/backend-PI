<?php
session_start();
require_once('../../config/config.php');

$conn = Conexao::getConn();

$id_usuario = $_SESSION['id_usuario'] ?? null;
$senha_antiga = $_POST['senha_antiga'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$repetir_senha = $_POST['repetir_senha'] ?? '';

if (!$id_usuario) {
    die("Usuário não autenticado.");
}

if (empty($senha_antiga) || empty($nova_senha) || empty($repetir_senha)) {
    die("Todos os campos são obrigatórios.");
}

if ($nova_senha !== $repetir_senha) {
    die("As novas senhas não coincidem.");
}

if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/", $nova_senha)) {
    die("A nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
}

$sql = "SELECT senha_usuario FROM USUARIO WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario]);

if ($stmt->rowCount() === 0) {
    die("Usuário não encontrado.");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$senha_hash = $row['senha_usuario'];

if (!password_verify($senha_antiga, $senha_hash)) {
    die("Senha atual incorreta.");
}

$nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

$sql_update = "UPDATE USUARIO SET senha_usuario = ? WHERE id_usuario = ?";
$stmt_update = $conn->prepare($sql_update);
$executou = $stmt_update->execute([$nova_senha_hash, $id_usuario]);

if ($executou) {
    header("Location: /backend-PI-leticia/public/profile.php?sucesso=senha_alterada");
    exit;

} else {
    die("Erro ao atualizar a senha.");
}

?>
