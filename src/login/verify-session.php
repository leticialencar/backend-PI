<?php
session_start();

$tempoInatividade = 2000000;

if (isset($_SESSION['ULTIMA_ATIVIDADE'])) {
    $inativo = time() - $_SESSION['ULTIMA_ATIVIDADE'];
    if ($inativo > $tempoInatividade) {

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: ../public/login.html?erro=2");
        exit;
    }
}

$_SESSION['ULTIMA_ATIVIDADE'] = time();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../public/login.html");
    exit;
}
