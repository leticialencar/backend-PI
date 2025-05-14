<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'], $_SESSION['nome_usuario'], $_SESSION['documento_usuario'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

function formatarDocumento($doc) {
    if (strlen($doc) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $doc);
    } elseif (strlen($doc) === 14) {
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $doc);
    }
    return $doc;
}

echo json_encode([
    'nome' => $_SESSION['nome_usuario'],
    'documento' => formatarDocumento($_SESSION['documento_usuario'])
]);
