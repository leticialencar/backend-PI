<?php
require __DIR__ . '/../../config/config.php';
$conn = Conexao::getConn();

$busca = $_GET['busca'] ?? '';

try {
  $sql = "
    SELECT f.id_funcionario, f.nome_funcionario, c.nome_cargo
    FROM FUNCIONARIO f
    LEFT JOIN CARGO c ON f.id_cargo = c.id_cargo
    WHERE f.nome_funcionario LIKE :busca OR c.nome_cargo LIKE :busca
  ";
  $stmt = $conn->prepare($sql);
  $stmt->execute(['busca' => '%' . $busca . '%']);
  $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($funcionarios as $funcionario) {
    echo "<tr>
      <td><a href='folha_de_pagamento.php?id={$funcionario['id_funcionario']}'>" . htmlspecialchars($funcionario['nome_funcionario']) . "</a></td>
      <td>" . htmlspecialchars($funcionario['nome_cargo']) . "</td>
      <td class='actions'>
        <button class='open-modal' data-id='{$funcionario['id_funcionario']}' data-modal='modal-cadastro'>Editar</button>
        <button class='btn-desativar-conta js-open-modal-desativar' data-id='{$funcionario['id_funcionario']}' data-modal='modal-1'>Desativar</button>
      </td>
    </tr>";
  }

} catch (PDOException $e) {
  echo "<tr><td colspan='3'>Erro: " . $e->getMessage() . "</td></tr>";
}
