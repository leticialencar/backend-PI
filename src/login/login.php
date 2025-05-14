<?php
include('../../config/config.php');
require_once __DIR__ . '/../alert/email-alert.php';

$tempoInatividade = 1800;

ini_set('session.gc_maxlifetime', $tempoInatividade);
ini_set('session.cookie_lifetime', 0);

session_start();

$erro = '';

function limparDocumento($doc) {
    return preg_replace('/\D/', '', $doc);
}

function validarDocumento($doc) {
    $doc = limparDocumento($doc);
    return strlen($doc) === 11 || strlen($doc) === 14;
}

function autenticar($mysqli, $login, $senha, &$id_usuario = null) {
    $loginLimpo = limparDocumento($login);
    $campo = strlen($loginLimpo) === 11 ? 'cpf_usuario' : 'cnpj_usuario';

    $sql = "SELECT id_usuario, nome_usuario, senha_usuario FROM USUARIO WHERE $campo = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $loginLimpo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        $id_usuario = $usuario['id_usuario'];

        if ($senha === $usuario['senha_usuario']) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
            $_SESSION['documento_usuario'] = $loginLimpo;
            $_SESSION['ULTIMA_ATIVIDADE'] = time();
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $id_usuario = null;

    if (!validarDocumento($login)) {
        header("Location: ../../public/login.html?erro=1");
        exit;
    } elseif (!autenticar($mysqli, $login, $senha, $id_usuario)) {
        if ($id_usuario !== null) {
            $alerta = new AlertaSeguranca($mysqli);
            $alerta->enviarAlerta($id_usuario);
        }
        header("Location: ../../public/login.html?erro=1");
        exit;
    } else {
        header("Location: ../../public/homepage.html");
        exit;
    }
}

// Verifica sessão ativa para testes (opcional)
if (isset($_SESSION['ULTIMA_ATIVIDADE'])) {
    $inativo = time() - $_SESSION['ULTIMA_ATIVIDADE'];
    if ($inativo > $tempoInatividade) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
    $_SESSION['ULTIMA_ATIVIDADE'] = time();
}

if (isset($_SESSION['documento_usuario'])) {
    echo "<h1>Bem-vindo, CPF/CNPJ: " . htmlspecialchars($_SESSION['documento_usuario']) . "</h1>";
    echo "<p>Sua sessão está ativa.</p>";
    echo "<form method='post' action='logout.php'>
            <button type='submit'>Sair</button>
          </form>";
    exit;
}
?>
