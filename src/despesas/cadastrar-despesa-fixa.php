<?php
require __DIR__ . '/../../config/config.php';

$conn = Conexao::getConn();

$data_pagamento = $_POST['data_pagamento'];
$data_vencimento = $_POST['data_vencimento'];
$categoria = $_POST['categoria'];
$valor = $_POST['valor'];
$forma_pagamento = $_POST['forma_pagamento'];
$observacoes = $_POST['observacoes'];

if ($categoria == 'agua') {
    $tabela = 'DESPESA_AGUA';
} elseif ($categoria == 'energia') {
    $tabela = 'DESPESA_ENERGIA';
} else {
    die('Categoria inválida!');
}

$sql = "INSERT INTO $tabela (data_conta, data_pagamento, descricao, valor)
        VALUES (:data_conta, :data_pagamento, :descricao, :valor)";

$stmt = $conn->prepare($sql);

$executado = $stmt->execute([
    ':data_conta' => $data_vencimento,
    ':data_pagamento' => $data_pagamento,
    ':descricao' => $observacoes . ' - Forma: ' . $forma_pagamento,
    ':valor' => $valor
]);

if ($executado) {
    echo "Despesa cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar despesa!";
}
?>
