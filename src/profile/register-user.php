<?php
session_start();
include('../../config/config.php'); 

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../../public/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $cpf = preg_replace('/\D/', '', $_POST['cpf']);
    $email = trim($_POST['email']);
    $cargo = trim($_POST['cargo']);  
    $nivel = intval($_POST['nivel']); 
    $senha = $_POST['senha'];

    if (strlen($cpf) !== 11) {
        die("CPF inválido");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido");
    }

    if (!$nome || !$sobrenome || !$cargo || !$nivel || !$senha) {
        die("Preencha todos os campos.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $data_adicao = date('Y-m-d');

    try {
        $pdo = Conexao::getConn();

        $nome_completo = $nome . ' ' . $sobrenome;

        $sql = "INSERT INTO USUARIO (nome_usuario, cpf_usuario, email_usuario, senha_usuario, data_adicao) 
                VALUES (:nome, :cpf, :email, :senha, :data_adicao)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome_completo);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':data_adicao', $data_adicao);

        $stmt->execute();

        header("Location: ../../public/homepage.php?msg=usuario_cadastrado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao cadastrar usuário: " . $e->getMessage());
    }
} else {
    header("Location: ../../public/homepage.php");
    exit;
}
?>
