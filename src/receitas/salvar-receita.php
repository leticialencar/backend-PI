<?php
require_once('../../config/config.php');

header('Content-Type: application/json');

try {
    $conn = Conexao::getConn();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão']);
    exit;
}

// Receber os dados do POST
$data_venda = $_POST['data-venda'] ?? null;
$nome_cliente = $_POST['nome-cliente'] ?? null;
$id_produto = isset($_POST['nome-produto']) ? (int)$_POST['nome-produto'] : null;
$id_sabor = isset($_POST['sabor-produto']) ? (int)$_POST['sabor-produto'] : null;
$qtd_produto = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : null;
$val_unitario = isset($_POST['valor-unitario']) ? (float)$_POST['valor-unitario'] : null;
$id_categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : null;
$id_pagamento = isset($_POST['pagamento']) ? (int)$_POST['pagamento'] : null; // caso queira salvar

// Validar campos obrigatórios
if (empty($data_venda) || empty($nome_cliente) || !$id_produto || !$id_sabor || !$qtd_produto || !$val_unitario || !$id_categoria || !$id_pagamento) {
    http_response_code(400);
    echo json_encode(['error' => 'Campos obrigatórios faltando ou inválidos']);
    exit;
}

if ($qtd_produto <= 0 || $val_unitario <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Quantidade e valor unitário devem ser maiores que zero']);
    exit;
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_venda)) {
    http_response_code(400);
    echo json_encode(['error' => 'Data inválida']);
    exit;
}

// Calcular total
$total_receita = $qtd_produto * $val_unitario;

// Se quiser pegar o nome do produto via ID
$stmtProd = $conn->prepare("SELECT nome_produto FROM produtos WHERE id_produto = :id_produto");
$stmtProd->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);
$stmtProd->execute();
$prod = $stmtProd->fetch(PDO::FETCH_ASSOC);
if (!$prod) {
    http_response_code(400);
    echo json_encode(['error' => 'Produto não encontrado']);
    exit;
}
$nome_produto = $prod['nome_produto'];

// Agora inserir
$sql = "INSERT INTO RECEITA (data_venda, nome_cliente, nome_produto, id_sabor, qtd_produto, val_unitario, id_categoria, id_forma_pagamento, total_receita)
        VALUES (:data_venda, :nome_cliente, :nome_produto, :id_sabor, :qtd_produto, :val_unitario, :id_categoria, :id_pagamento, :total_receita)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na preparação da query']);
    exit;
}

$stmt->bindValue(':data_venda', $data_venda, PDO::PARAM_STR);
$stmt->bindValue(':nome_cliente', $nome_cliente, PDO::PARAM_STR);
$stmt->bindValue(':nome_produto', $nome_produto, PDO::PARAM_STR);
$stmt->bindValue(':id_sabor', $id_sabor, PDO::PARAM_INT);
$stmt->bindValue(':qtd_produto', $qtd_produto, PDO::PARAM_INT);
$stmt->bindValue(':val_unitario', $val_unitario);
$stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_INT);
$stmt->bindValue(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
$stmt->bindValue(':total_receita', $total_receita);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Receita salva com sucesso!']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao salvar receita']);
}
?>
