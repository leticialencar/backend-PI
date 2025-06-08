<?php
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

// 1. Verificar se veio o ID pela URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Funcionário inválido.");
}

$id = (int) $_GET['id'];

// 2. Buscar os dados do funcionário e cargo
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

// 3. Cálculo simples
$salario = $funcionario['salario'];
$fgts = $salario * 0.08;   // 8%
$inss = $salario * 0.09;   // 9%
$ir = $salario * 0.01;     // 1%
$descontos = $fgts + $inss + $ir;
$salario_liquido = $salario - $descontos;
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
      <div><strong>Funcionário:</strong> Brenda Evelyn da Silva Vieira</div>
      <div><strong>Cargo:</strong> Caixa</div>
      <div><strong>Data de admissão:</strong> 02/01/2025</div>
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
          <td>2.000,00</td>
          <td>-</td>
        </tr>
        <tr>
          <td>FGTS</td>
          <td>-</td>
          <td>150,00</td>
        </tr>
        <tr>
          <td>INSS</td>
          <td>-</td>
          <td>180,00</td>
        </tr>

         <tr>
          <td>Imposto de renda</td>
          <td>-</td>
          <td>20,00</td>
        </tr>

        <tr class="total">
          <td>Salário Líquido</td>
          <td colspan="2">R$ 1.650,00</td>
        </tr>
      </tbody>
    </table>