<?php
require __DIR__ . '/../../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = Conexao::getConn();
    $stmt = $conn->prepare("SELECT * FROM FUNCIONARIO WHERE id_funcionario = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario) {
        echo json_encode($funcionario);
    } else {
        echo json_encode(['error' => 'Funcionário não encontrado']);
    }
}
?>
