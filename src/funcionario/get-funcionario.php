<?php
require __DIR__ . '/../../config/config.php';
$conn = Conexao::getConn();

$id = $_GET['id'] ?? null;
if (!$id) exit(json_encode(['erro'=>'ID não enviado']));

try {
  $sql = "
    SELECT f.id_funcionario, f.nome_funcionario, f.rg_funcionario AS rg,
           f.cpf_funcionario AS cpf, f.data_admissao,
           f.salario,
           e.cep_funcionario AS cep, e.rua_funcionario AS rua,
           e.numero_funcionario AS numero, e.bairro_funcionario AS bairro,
           e.cidade_funcionario AS cidade, e.estado_funcionario AS estado,
           t.ddd_funcionario AS ddd, t.num_telefone_funcionario AS contato,
           f.id_cargo
    FROM FUNCIONARIO f
    LEFT JOIN endereco_funcionario e ON e.id_funcionario = f.id_funcionario
    LEFT JOIN telefone_funcionario t ON t.id_funcionario = f.id_funcionario
    WHERE f.id_funcionario = :id
  ";
  $stmt = $conn->prepare($sql);
  $stmt->execute(['id'=>$id]);
  $dados = $stmt->fetch(PDO::FETCH_ASSOC);
  exit(json_encode($dados));
} catch (PDOException $e) {
  exit(json_encode(['erro'=>$e->getMessage()]));
}
?>
