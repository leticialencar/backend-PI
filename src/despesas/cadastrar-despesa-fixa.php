<?php
require __DIR__ . '/../../config/config.php';

$conn = Conexao::getConn();

$data_pagamento = $_POST['data_pagamento'];
$data_vencimento = $_POST['data_vencimento'];
$categoria = $_POST['categoria']; 
$valor = $_POST['valor'];
$forma_pagamento_id = $_POST['forma_pagamento'];
$observacoes = $_POST['observacoes'];

$categorias_validas = ['Água', 'Energia', 'Internet'];
if (!in_array($categoria, $categorias_validas)) {
    die('Categoria inválida!');
}

$sql = "INSERT INTO despesas_fixas (categoria, data_conta, data_pagamento, descricao, valor, id_forma_pagamento)
        VALUES (:categoria, :data_conta, :data_pagamento, :descricao, :valor, :id_forma_pagamento)";

$stmt = $conn->prepare($sql);

$cadastrar_despesa_fixa = $stmt->execute([
    ':categoria' => $categoria,
    ':data_conta' => $data_vencimento,
    ':data_pagamento' => $data_pagamento,
    ':descricao' => $observacoes,
    ':valor' => $valor,
    ':id_forma_pagamento' => $forma_pagamento_id
]);

if ($cadastrar_despesa_fixa) {
    echo "Despesa cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar despesa!";
}
?>
