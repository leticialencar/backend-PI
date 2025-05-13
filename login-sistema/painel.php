<?php
session_start();

$tempoInatividade = 5; // tempo em segundos


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Verifica tempo de inatividade 
if (isset($_SESSION['ULTIMA_ATIVIDADE'])) {
    $inativo = time() - $_SESSION['ULTIMA_ATIVIDADE'];
    if ($inativo > $tempoInatividade) {
        header("Location: logout.php");
        exit;
    }
}
$_SESSION['ULTIMA_ATIVIDADE'] = time();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
</head>
<body>
    <h1>Bem-vindo, CPF/CNPJ: <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    <p>Sua sessão está ativa.</p>

    <form method="post" action="logout.php">
        <button type="submit">Sair</button>
    </form>

    <!-- Script de inatividade -->
    <script>
        const tempoInatividade = <?= $tempoInatividade * 1000 ?>; //milissegundos
        let timeout;

        function iniciarTemporizador() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                window.location.href = 'logout.php'; 
            }, tempoInatividade);
        }


        ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evento => {
            document.addEventListener(evento, iniciarTemporizador);
        });

        iniciarTemporizador();
    </script>
</body>
</html>

