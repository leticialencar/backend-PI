<?php
include('../../config/config.php');
require_once __DIR__ . '/../alert/email-alert.php';

session_start();

$erro = '';

function limparDocumento($doc) {
    return preg_replace('/\D/', '', $doc);
}

function validarDocumento($doc) {
    $doc = limparDocumento($doc);
    return strlen($doc) === 11 || strlen($doc) === 14;
}

function autenticar(PDO $pdo, $login, $senha) {
    $loginLimpo = limparDocumento($login);
    $campo = strlen($loginLimpo) === 11 ? 'cpf_usuario' : 'cnpj_usuario';

    $sql = "SELECT id_usuario, nome_usuario, senha_usuario, tipo_usuario FROM USUARIO WHERE $campo = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':login', $loginLimpo, PDO::PARAM_STR);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if (password_verify($senha, $usuario['senha_usuario'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
            $_SESSION['documento_usuario'] = $loginLimpo;
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; // ✅ seta o tipo do usuário na sessão
            $_SESSION['ULTIMA_ATIVIDADE'] = time();
            return true;
        } else {
            return $usuario['id_usuario'];
        }
    }

    return false; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!validarDocumento($login)) {
        header("Location: ../../public/login.html?erro=1");
        exit;
    }

    $pdo = Conexao::getConn();

    $resultadoAutenticacao = autenticar($pdo, $login, $senha);

    if ($resultadoAutenticacao === true) {
        header("Location: ../../public/homepage.php");
        exit;
    } elseif (is_numeric($resultadoAutenticacao)) {
        $alerta = new AlertaSeguranca($pdo);
        $alerta->enviarAlerta($resultadoAutenticacao);
        header("Location: ../../public/login.html?erro=1");
        exit;
    } else {
        header("Location: ../../public/login.html?erro=1");
        exit;
    }
}
