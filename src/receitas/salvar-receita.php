<?php
require_once('../../config/config.php');

header('Content-Type: application/json');

try {
    $conn = Conexao::getConn();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => "Erro na conexão com o banco de dados: " . $e->getMessage()]);
    exit;
}

// Captura e sanitiza os dados
$data_venda = $_POST['data-venda'] ?? null;
$nome_cliente = $_POST['nome-cliente'] ?? null;
$nome_produto = $_POST['nome-produto'] ?? null;
$qtd_produto = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : null;
$val_unitario = isset($_POST['valor-unitario']) ? (float)$_POST['valor-unitario'] : null;
$id_categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : null;

// Validações básicas
if (empty($data_venda) || empty($nome_cliente) || empty($nome_produto) || $qtd_produto === null || $val_unitario === null || $id_categoria === null) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}

// Validação simples do formato da data (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_venda)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Formato da data inválido. Use YYYY-MM-DD.']);
    exit;
}

// Calcula total formatado para 2 casas decimais
$total_receita = number_format($qtd_produto * $val_unitario, 2, '.', '');

$sql = "INSERT INTO RECEITA (data_venda, nome_cliente, nome_produto, qtd_produto, val_unitario, id_categoria, total_receita)
        VALUES (:data_venda, :nome_cliente, :nome_produto, :qtd_produto, :val_unitario, :id_categoria, :total_receita)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da query.']);
    exit;
}

$stmt->bindValue(':data_venda', $data_venda, PDO::PARAM_STR);
$stmt->bindValue(':nome_cliente', $nome_cliente, PDO::PARAM_STR);
$stmt->bindValue(':nome_produto', $nome_produto, PDO::PARAM_STR);
$stmt->bindValue(':qtd_produto', $qtd_produto, PDO::PARAM_INT);
$stmt->bindValue(':val_unitario', $val_unitario);
$stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_INT);
$stmt->bindValue(':total_receita', $total_receita);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Receita salva com sucesso!']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar receita.']);
}
