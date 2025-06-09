<?php
include '../src/login/verify-session.php';
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

$fgts = $salario * 0.08;

function calcularINSS($salario) {
    $faixas = [
        [0.00, 1518.00, 0.075],
        [1518.01, 2793.88, 0.09],
        [2793.89, 4190.83, 0.12],
        [4190.84, 8157.41, 0.14]
    ];

    $inss = 0;
    foreach ($faixas as $faixa) {
        list($min, $max, $aliquota) = $faixa;

        if ($salario > $max) {
            $inss += ($max - $min) * $aliquota;
        } else {
            $inss += ($salario - $min) * $aliquota;
            break;
        }
    }

    return min($inss, 908.85); 
}

function calcularIR($salario, $inss) {
    $base = $salario - $inss;

    if ($base <= 2259.20) {
        return 0;
    } elseif ($base <= 2826.65) {
        return ($base * 0.075) - 169.44;
    } elseif ($base <= 3751.05) {
        return ($base * 0.15) - 381.44;
    } elseif ($base <= 4664.68) {
        return ($base * 0.225) - 662.77;
    } else {
        return ($base * 0.275) - 896.00;
    }
}

$inss = calcularINSS($salario);
$ir = calcularIR($salario, $inss);
$descontos = $inss + $ir;
$salario_liquido = $salario - $descontos;

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
          <td>FGTS (depositado pela empresa)</td>
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

  <script src="../assets/js/inatividade.js"></script>

</body>
</html>
