<?php
header('Content-Type: application/json');
session_start();
require_once('../../config/config.php');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Você precisa estar logado.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
    exit;
}

$pdo = Conexao::getConn();
$id_usuario = $_SESSION['id_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'user';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$documento = trim($_POST['cpf'] ?? '');

$cep = trim($_POST['cep'] ?? '');
$rua = trim($_POST['rua'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = trim($_POST['estado'] ?? '');

$ddd = trim($_POST['ddd'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');

if (empty($nome) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Nome e email são obrigatórios.']);
    exit;
}

try {
    $pdo->beginTransaction();

    if ($tipo_usuario === 'admin') {
        $sqlUsuario = "UPDATE USUARIO SET nome_usuario = :nome, cnpj_usuario = :documento, email_usuario = :email WHERE id_usuario = :id";
    } else {
        $sqlUsuario = "UPDATE USUARIO SET nome_usuario = :nome, cpf_usuario = :documento, email_usuario = :email WHERE id_usuario = :id";
    }
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->bindValue(':nome', $nome);
    $stmtUsuario->bindValue(':documento', $documento);
    $stmtUsuario->bindValue(':email', $email);
    $stmtUsuario->bindValue(':id', $id_usuario, PDO::PARAM_INT);
    $stmtUsuario->execute();

    $sqlEndereco = "SELECT id_endereco FROM ENDERECO WHERE id_usuario = :id";
    $stmtEndereco = $pdo->prepare($sqlEndereco);
    $stmtEndereco->bindValue(':id', $id_usuario, PDO::PARAM_INT);
    $stmtEndereco->execute();

    if ($stmtEndereco->rowCount() > 0) {
        $sql = "UPDATE ENDERECO SET cep = :cep, rua = :rua, bairro = :bairro, cidade = :cidade, estado = :estado WHERE id_usuario = :id";
    } else {
        $sql = "INSERT INTO ENDERECO (cep, rua, bairro, cidade, estado, id_usuario) VALUES (:cep, :rua, :bairro, :cidade, :estado, :id)";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cep', $cep);
    $stmt->bindValue(':rua', $rua);
    $stmt->bindValue(':bairro', $bairro);
    $stmt->bindValue(':cidade', $cidade);
    $stmt->bindValue(':estado', $estado);
    $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    $sqlTelefone = "SELECT id_telefone FROM TELEFONE WHERE id_usuario = :id";
    $stmtTelefone = $pdo->prepare($sqlTelefone);
    $stmtTelefone->bindValue(':id', $id_usuario, PDO::PARAM_INT);
    $stmtTelefone->execute();

    if ($stmtTelefone->rowCount() > 0) {
        $sql = "UPDATE TELEFONE SET num_telefone = :telefone, ddd = :ddd WHERE id_usuario = :id";
    } else {
        $sql = "INSERT INTO TELEFONE (num_telefone, ddd, id_usuario) VALUES (:telefone, :ddd, :id)";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':ddd', $ddd);
    $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    $pdo->commit();

    $_SESSION['nome_usuario'] = $nome;
    $_SESSION['documento_usuario'] = $documento;

    echo json_encode(['status' => 'success', 'message' => 'Perfil atualizado com sucesso!']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar perfil: ' . $e->getMessage()]);
}
