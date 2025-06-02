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
        $fornecedor = $_POST['fornecedor'] ?? null;

        $total_despesa = floatval($valor_unitario) * intval($quantidade);

        if (!$data_compra || !$validade || !$nome_produto || !$valor_unitario || !$quantidade || !$fornecedor) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $stmt = $conn->prepare("INSERT INTO DESPESA_PRODUTO 
            (data_compra, nome_produto, qtd_produto, val_unitario, total_despesa, validade, fornecedor) 
            VALUES 
            (:data_compra, :nome_produto, :qtd_produto, :val_unitario, :total_despesa, :validade, :fornecedor)");

        $stmt->execute([
            ':data_compra' => $data_compra,
            ':nome_produto' => $nome_produto,
            ':qtd_produto' => $quantidade,
            ':val_unitario' => $valor_unitario,
            ':total_despesa' => $total_despesa,
            ':validade' => $validade,
            ':fornecedor' => $fornecedor,
        ]);

        echo "Despesa cadastrada com sucesso!";

    } else {
        throw new Exception("Método inválido.");
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
