<?php
require __DIR__ . '/../../config/config.php';

$conn = Conexao::getConn();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data_compra = $_POST['data-compra'] ?? null;
        $validade = $_POST['validade'] ?? null;
        $nome_produto = trim($_POST['nome-produto'] ?? '');
        $valor_unitario = $_POST['valor-unitario'] ?? 0;
        $quantidade = $_POST['quantidade'] ?? 0;
        $id_fornecedor = $_POST['id_fornecedor'] ?? null;

        $total_despesa = floatval($valor_unitario) * intval($quantidade);

        if (
            empty($data_compra) ||
            empty($validade) ||
            empty($nome_produto) ||
            !is_numeric($valor_unitario) || floatval($valor_unitario) <= 0 ||
            !is_numeric($quantidade) || intval($quantidade) <= 0 ||
            !is_numeric($id_fornecedor) || intval($id_fornecedor) <= 0
        ) {
            throw new Exception("Todos os campos são obrigatórios e devem ser válidos.");
        }

        $stmt = $conn->prepare("INSERT INTO DESPESA_PRODUTO 
            (data_compra, nome_produto, qtd_produto, val_unitario, total_despesa, validade, id_fornecedor) 
            VALUES 
            (:data_compra, :nome_produto, :qtd_produto, :val_unitario, :total_despesa, :validade, :id_fornecedor)");

        $stmt->execute([
            ':data_compra' => $data_compra,
            ':nome_produto' => $nome_produto,
            ':qtd_produto' => intval($quantidade),
            ':val_unitario' => floatval($valor_unitario),
            ':total_despesa' => $total_despesa,
            ':validade' => $validade,
            ':id_fornecedor' => intval($id_fornecedor),
        ]);

        echo "Despesa cadastrada com sucesso!";

    } else {
        throw new Exception("Método inválido.");
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
