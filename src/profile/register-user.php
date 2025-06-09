<?php
require('../../config/config.php');

header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos (JSON malformado).']);
    exit;
}

$nome = trim($input['nome'] ?? '');
$sobrenome = trim($input['sobrenome'] ?? '');
$cpf = preg_replace('/\D/', '', $input['cpf'] ?? '');
$email = trim($input['email'] ?? '');
$cargo = intval($input['cargo'] ?? 0);
$senha = $input['senha'] ?? '';

function validarDados($nome, $sobrenome, $cpf, $email, $cargo, $senha) {
    if (empty($nome) || empty($sobrenome) || empty($cargo) || empty($senha)) {
        return ['success' => false, 'message' => 'Preencha todos os campos obrigatórios.'];
    }
    if (strlen($cpf) !== 11) {
        return ['success' => false, 'message' => 'CPF inválido.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Email inválido.'];
    }
    return ['success' => true];
}

function inserirUsuario($pdo, $nomeCompleto, $cpf, $email, $senhaHash, $cargo) {
    $sql = "INSERT INTO USUARIO (
                nome_usuario, cpf_usuario, cnpj_usuario,
                email_usuario, senha_usuario, data_adicao,
                tipo_usuario, id_cargo, ativo
            ) VALUES (
                :nome, :cpf, '', 
                :email, :senha, NOW(), 
                'padrao', :cargo, 1
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nomeCompleto);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senhaHash);
    $stmt->bindParam(':cargo', $cargo);

    if (!$stmt->execute()) {
        $erro = $stmt->errorInfo();
        throw new Exception("Erro ao executar INSERT: " . $erro[2]);
    }

    return true;
}

function verificarDuplicidade($pdo, $cpf, $email) {
    $sqlCheck = "SELECT COUNT(*) FROM USUARIO WHERE cpf_usuario = :cpf OR email_usuario = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':cpf', $cpf);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();
    return $stmtCheck->fetchColumn() > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validacao = validarDados($nome, $sobrenome, $cpf, $email, $cargo, $senha);
    if (!$validacao['success']) {
        echo json_encode($validacao);
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $nomeCompleto = $nome . ' ' . $sobrenome;

    try {
        $pdo = Conexao::getConn();

        if (verificarDuplicidade($pdo, $cpf, $email)) {
            echo json_encode(['success' => false, 'message' => 'CPF ou Email já cadastrados.']);
            exit;
        }

        inserirUsuario($pdo, $nomeCompleto, $cpf, $email, $senhaHash, $cargo);

        echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso!']);
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro com o banco: ' . $e->getMessage()]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
    exit;
}
