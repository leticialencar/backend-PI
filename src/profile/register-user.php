<?php
session_start();
require('../../config/config.php');

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../../public/login.php");
    exit;
}

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

    return $stmt->execute();
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
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $cpf = preg_replace('/\D/', '', $_POST['cpf']);
    $email = trim($_POST['email']);
    $cargo = intval($_POST['cargo']);
    $senha = $_POST['senha'];

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

        if (inserirUsuario($pdo, $nomeCompleto, $cpf, $email, $senhaHash, $cargo)) {
    header("Location: ../../public/homepage.php?msg=usuario_cadastrado");
    exit;
} else {
    $erro = $pdo->errorInfo();
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao cadastrar usuário: ' . $erro[2]
    ]);
    exit;
}
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
        exit;
    }
} else {
    header("Location: ../../public/homepage.php");
    exit;
}