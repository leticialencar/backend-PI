<?php 
include '../src/login/verify-session.php'; 
require __DIR__ . '/../config/config.php';

try {
    $conn = Conexao::getConn();
    
    $nomeProduto = 'Kibon';

    $sqlClientes = "SELECT DISTINCT nome_cliente 
                    FROM RECEITA 
                    WHERE nome_produto = :produto AND nome_cliente IS NOT NULL 
                    ORDER BY nome_cliente";
    $stmt = $conn->prepare($sqlClientes);
    $stmt->execute(['produto' => $nomeProduto]);
    $clientes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlPagamentos = "SELECT DISTINCT f.descricao 
                      FROM RECEITA r
                      JOIN FORMAS_PAGAMENTO f ON r.id_forma_pagamento = f.id_forma_pagamento
                      WHERE r.nome_produto = :produto
                      ORDER BY f.descricao";
    $stmt = $conn->prepare($sqlPagamentos);
    $stmt->execute(['produto' => $nomeProduto]);
    $pagamentos = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlCategorias = "SELECT DISTINCT c.nome_categoria 
                      FROM RECEITA r
                      JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria
                      WHERE r.nome_produto = :produto
                      ORDER BY c.nome_categoria";
    $stmt = $conn->prepare($sqlCategorias);
    $stmt->execute(['produto' => $nomeProduto]);
    $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlSabores = "SELECT DISTINCT s.nome_sabor 
                   FROM RECEITA r
                   JOIN SABOR_PRODUTO s ON r.id_sabor = s.id_sabor
                   WHERE r.nome_produto = :produto
                   ORDER BY s.nome_sabor";
    $stmt = $conn->prepare($sqlSabores);
    $stmt->execute(['produto' => $nomeProduto]);
    $sabores = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlQuantidades = "SELECT DISTINCT qtd_produto 
                       FROM RECEITA 
                       WHERE nome_produto = :produto 
                       ORDER BY qtd_produto";
    $stmt = $conn->prepare($sqlQuantidades);
    $stmt->execute(['produto' => $nomeProduto]);
    $quantidades = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlValoresUnit = "SELECT DISTINCT val_unitario 
                       FROM RECEITA 
                       WHERE nome_produto = :produto 
                       ORDER BY val_unitario";
    $stmt = $conn->prepare($sqlValoresUnit);
    $stmt->execute(['produto' => $nomeProduto]);
    $valoresUnit = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlTotais = "SELECT DISTINCT total_receita 
                  FROM RECEITA 
                  WHERE nome_produto = :produto 
                  ORDER BY total_receita";
    $stmt = $conn->prepare($sqlTotais);
    $stmt->execute(['produto' => $nomeProduto]);
    $totais = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sqlDatas = "SELECT DISTINCT data_venda 
                 FROM RECEITA 
                 WHERE nome_produto = :produto 
                 ORDER BY data_venda DESC";
    $stmt = $conn->prepare($sqlDatas);
    $stmt->execute(['produto' => $nomeProduto]);
    $datasVenda = $stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/reset.css" />
  <link rel="stylesheet" href="../assets/css/receitas_kibon.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="stylesheet" href="../assets/css/modalsair.css" />
</head>
<body>
  <header class="container-header">
    <div class="logo">
      <img src="../assets/img/logo.png" alt="Logo CashHive" />
    </div>
    <div class="user">
      <p id="user-info">Carregando usuário...</p>
      <script src="../assets/js/get-username.js" defer></script>
    </div>
  </header>

  <div class="main-container">
    <aside class="menu">
      <nav class="nav">
        <ul>
          <li>
            <img src="../assets/img/homeicon.svg" alt="Início" />
            <a href="../public/homepage.php">Página inicial</a>
          </li>
          <li>
            <img src="../assets/img/profileicon.svg" alt="Perfil" />
            <a href="../public/profile.php">Perfil</a>
          </li>
          <li>
            <details class="submenu">
              <summary>
                <img src="../assets/img/financeicon.svg" alt="Financeiro" />
                Financeiro
              </summary>
              <ul>
                <li><a href="../public/cadastrar_funcionario.php">Funcionário</a></li>
                <li><a href="../public/receitas_kibon.php">Receitas</a></li>
                <li><a href="../public/cadastrar_receitas.php">Cadastro de Receitas</a></li>
                <li><a href="../public/despesas_fixas.html">Despesas</a></li>
                <li><a href="../public/cadastrar_despesas_fixas.php">Cadastro de Despesas</a></li>
              </ul>
            </details>
          </li>
          <li class="logout">
            <img src="../assets/img/logouticon.svg" alt="Sair" />
            <button class="open-modal" data-modal="modal-sair">Sair</button>
          </li>
        </ul>
      </nav>
    </aside>

    <div class="nav-category">
      <nav class="nav-options">
        <ul>
          <li class="active"><a href="../public/receitas_kibon.html">Kibon</a></li>
          <li><a href="../public/receitas_nestle.html">Nestlé</a></li>
          <li><a href="../public/receitas_mareni.html">Mareni</a></li>
        </ul>
      </nav>
    </div>

    <!-- Div de Filtros -->
    <div class="nav-filter-category">
      <form id="filtro-form" method="GET">
        <div class="filters">
          <input type="date" id="data-filter" name="data" />

          <select id="cliente-filter" name="cliente">
            <option value="">Cliente</option>
            <?php foreach ($clientes as $cliente): ?>
              <option value="<?= htmlspecialchars($cliente) ?>"><?= htmlspecialchars($cliente) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="pagamento-filter" name="pagamento">
            <option value="">Pagamento</option>
            <?php foreach ($pagamentos as $pagamento): ?>
              <option value="<?= htmlspecialchars($pagamento) ?>"><?= htmlspecialchars($pagamento) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="categoria-filter" name="categoria">
            <option value="">Categoria</option>
            <?php foreach ($categorias as $categoria): ?>
              <option value="<?= htmlspecialchars($categoria) ?>"><?= htmlspecialchars($categoria) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="sabor-filter" name="sabor">
            <option value="">Sabor</option>
            <?php foreach ($sabores as $sabor): ?>
              <option value="<?= htmlspecialchars($sabor) ?>"><?= htmlspecialchars($sabor) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="quantidade-filter" name="quantidade">
            <option value="">Quantidade</option>
            <?php foreach ($quantidades as $quant): ?>
              <option value="<?= htmlspecialchars($quant) ?>"><?= htmlspecialchars($quant) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="valor-unit-filter" name="valor_unit">
            <option value="">Valor Unitário</option>
            <?php foreach ($valoresUnit as $valor): ?>
              <option value="<?= htmlspecialchars($valor) ?>">R$ <?= number_format($valor, 2, ',', '.') ?></option>
            <?php endforeach; ?>
          </select>

          <select id="total-filter" name="total">
            <option value="">Total</option>
            <?php foreach ($valoresTotais as $valor): ?>
              <option value="<?= htmlspecialchars($valor) ?>">R$ <?= number_format($valor, 2, ',', '.') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>
    </div>

    <!-- Tabela de Receitas -->
    <main class="main-tabela">
    <table class="tabela-receitas">
      <thead>
        <tr>
          <th>Data da Venda</th>
          <th>Cliente</th>
          <th>Pagamento</th>
          <th>Produto</th>
          <th>Categoria</th>
          <th>Sabor</th>
          <th>Quantidade</th>
          <th>Valor Unitário</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT r.data_venda, r.nome_cliente, f.descricao AS forma_pagamento, r.nome_produto, c.nome_categoria, s.nome_sabor, r.qtd_produto, r.val_unitario, r.total_receita
          FROM RECEITA r
          LEFT JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria
          LEFT JOIN SABOR_PRODUTO s ON r.id_sabor = s.id_sabor
          LEFT JOIN FORMAS_PAGAMENTO f ON r.id_forma_pagamento = f.id_forma_pagamento
          WHERE r.nome_produto LIKE '%Kibon%'
          ORDER BY r.data_venda DESC";

        $stmt = $conn->query($sql);

        if ($stmt) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . date("d/m/Y", strtotime($row['data_venda'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome_cliente']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['forma_pagamento']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome_produto']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome_categoria']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome_sabor']) . "</td>";
                    echo "<td>" . intval($row['qtd_produto']) . "</td>";
                    echo "<td>R$ " . number_format($row['val_unitario'], 2, ',', '.') . "</td>";
                    echo "<td>R$ " . number_format($row['total_receita'], 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Nenhum dado encontrado</td></tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Erro na consulta SQL</td></tr>";
        }

        $conn = null;
        ?>
      </tbody>
  </table>
</main>

      </table>
    </main>

    <div class="final-tabela">
      <div class="acoes">
        <div class="botoes">
          <p>* Selecionar pra excluir</p>
          <button class="btn-imprimir"><i class="fa fa-print"></i> Imprimir</button>
        </div>
      </div>
      <div class="total-gasto-box">
        <p class="total-gasto">TOTAL GANHO: R$ 3000,00</p>
      </div>
    </div>

    <!-- Modal de Sair -->
    <div class="modal-overlay hidden" id="modal-sair">
      <div class="modal-box">
        <button class="modal-close close-modal close-modal-sair" type="button">
          <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-subject">
          <div class="modal-header">
            <p class="modal-title">Deseja mesmo <span>sair</span> da conta?</p>
          </div>

          <div class="modal-form">
            <form>
              <div class="sim-btn">
                <a href="login.html"><button type="button" id="btn-sim">Sim</button></a>
              </div>
              <div class="nao-btn">
                <button type="button" id="btn-nao">Não</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="session-expired-toast" class="toast hidden">
    Sua sessão expirou! Faça o login novamente.
  </div>

  <script>
    document.querySelectorAll(".open-modal").forEach((button) => {
      button.addEventListener("click", () => {
        const modalId = button.getAttribute("data-modal");
        document.getElementById(modalId).classList.remove("hidden");
      });
    });

    document.querySelectorAll(".close-modal, #btn-nao").forEach((button) => {
      button.addEventListener("click", () => {
        button.closest(".modal-overlay").classList.add("hidden");
      });
    });

    window.addEventListener("click", (e) => {
      if (e.target.classList.contains("modal-overlay")) {
        e.target.classList.add("hidden");
      }
    });
  </script>

  <script>
    const form = document.getElementById('filtro-form');
    form.querySelectorAll('input, select').forEach(el => {
      el.addEventListener('change', () => {
        form.submit();
      });
    });
  </script>

  <script src="../assets/js/inatividade.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

</body>
</html>
