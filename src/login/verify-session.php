<?php
session_start();

$tempoInatividade = 1800; 

if (isset($_SESSION['ULTIMA_ATIVIDADE'])) {
    $inativo = time() - $_SESSION['ULTIMA_ATIVIDADE'];
    if ($inativo > $tempoInatividade) {
        session_unset();
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
