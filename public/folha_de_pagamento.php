<?php
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Funcionário inválido.");
}

$id = (int) $_GET['id'];

$sql = "
    SELECT f.nome_funcionario, f.salario, f.data_admissao, c.nome_cargo
    FROM FUNCIONARIO f
    JOIN CARGO c ON f.id_cargo = c.id_cargo
    WHERE f.id_funcionario = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    die("Funcionário não encontrado.");
}

$salario = $funcionario['salario'];
$fgts = $salario * 0.08;   // 8%
$inss = $salario * 0.09;   // 9%
$ir = $salario * 0.01;     // 1%
$descontos = $fgts + $inss + $ir;
$salario_liquido = $salario - $descontos;

// 4. Formatação
function formatar($valor) {
    return number_format($valor, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Folha de Pagamento</title>
  <link rel="stylesheet" href="../assets/css/folha_de_pagamento.css">
</head>
<body>
  <div class="container">
    <h2>Folha de Pagamento</h2>

    <section class="info-funcionario">
      <div><strong>Funcionário:</strong> <?= htmlspecialchars($funcionario['nome_funcionario']) ?></div>
      <div><strong>Cargo:</strong> <?= htmlspecialchars($funcionario['nome_cargo']) ?></div>
      <div><strong>Data de admissão:</strong> <?= date('d/m/Y', strtotime($funcionario['data_admissao'])) ?></div>
    </section>

    <table class="tabela-pagamento">
      <thead>
        <tr>
          <th>Descrição</th>
          <th>Proventos (R$)</th>
          <th>Descontos (R$)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Salário Base</td>
          <td><?= formatar($salario) ?></td>
          <td>-</td>
        </tr>
        <tr>
          <td>FGTS</td>
          <td>-</td>
          <td><?= formatar($fgts) ?></td>
        </tr>
        <tr>
          <td>INSS</td>
          <td>-</td>
          <td><?= formatar($inss) ?></td>
        </tr>
        <tr>
          <td>Imposto de Renda</td>
          <td>-</td>
          <td><?= formatar($ir) ?></td>
        </tr>
        <tr class="total">
          <td>Salário Líquido</td>
          <td colspan="2">R$ <?= formatar($salario_liquido) ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
