<?php
$tempoInatividade = 1800;

$usuarios = [
    '12345678900'    => 'senha123',
    '12345678000199' => 'senha456',
];

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

function autenticar($login, $senha, $usuarios) {
    $loginLimpo = limparDocumento($login);
    if (!isset($usuarios[$loginLimpo])) {
        return false;
    }
    return $usuarios[$loginLimpo] === $senha;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!validarDocumento($login)) {
        $erro = 'CPF ou CNPJ inválido. Use apenas números (11 ou 14 dígitos).';
    } elseif (!autenticar($login, $senha, $usuarios)) {
        $erro = 'CPF/CNPJ ou senha incorretos.';
    } else {
        $_SESSION['usuario'] = limparDocumento($login);
        $_SESSION['ULTIMA_ATIVIDADE'] = time();
        header("Location: login.php");
        exit;
    }
}

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

if (isset($_SESSION['usuario'])) {
    echo "<h1>Bem-vindo, CPF/CNPJ: " . htmlspecialchars($_SESSION['usuario']) . "</h1>";
    echo "<p>Sua sessão está ativa.</p>";
    echo "<form method='post' action='logout.php'>
            <button type='submit'>Sair</button>
          </form>";
    exit;
}
?>


"Formulario de login abaixo"

