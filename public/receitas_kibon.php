<?php include '../src/login/verify-session.php'; ?>

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
      <div class="filters">
        <input type="date" id="data-filter" name="data" />

        <select id="cliente-filter" name="cliente">
          <option value="cliente">Cliente</option>
          <option value="cliente1">Cliente 1</option>
          <option value="cliente2">Cliente 2</option>
          <option value="cliente3">Cliente 3</option>
        </select>

        <select id="pagamento-filter" name="pagamento">
          <option value="pagamento">Pagamento</option>
          <option value="pagamento1">Pagamento 1</option>
          <option value="pagamento2">Pagamento 2</option>
          <option value="pagamento">Pagamento 3</option>
        </select>

        <select id="produto-filter" name="produto">
          <option value="produto">Produto</option>
          <option value="produto1">Produto 1</option>
          <option value="produto2">Produto 2</option>
          <option value="produto3">Produto 3</option>
        </select>

        <select id="categoria-filter" name="categoria">
          <option value="categoria">Categoria</option>
          <option value="categoria1">Categoria 1</option>
          <option value="categoria2">Categoria 2</option>
          <option value="categoria3">Categoria 3</option>
        </select>

        <select id="sabor-filter" name="sabor">
          <option value="quantidade">Sabor</option>
          <option value="quantidade1">Morango</option>
          <option value="quantidade2">Chocolate</option>
          <option value="quantidade3">Maracujá</option>
          <option value="quantidade3">Creme com passas</option>
          </select>

        <select id="quandtidade-filter" name="quantidade">
          <option value="quantidade">Quantidade</option>
          <option value="quantidade1">Quantidade 1</option>
          <option value="quantidade2">Quantidade 2</option>
          <option value="quantidade3">Quantidade 3</option>
        </select>

        <select id="valor-unit-filter" name="valor-unit">
          <option value="valor-unit">Valor Unitário</option>
          <option value="valor-unit1">Valor Unitário 1</option>
          <option value="valor-unit2">Valor Unitário 2</option>
          <option value="valor-unit3">Valor Unitário 3</option>
        </select>

        <select id="total-filter" name="total">
          <option value="total">Total</option>
          <option value="total1">Total 1</option>
          <option value="total2">Total 2</option>
          <option value="total3">Total 3</option>
        </select>
      </div>
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
          </tr>
        </thead>
        <tbody>
          <?php
          require __DIR__ . '/../config/config.php';

          $conn = Conexao::getConn();

          $sql = "SELECT r.data_venda, r.nome_cliente, p.descricao AS pagamento, r.nome_produto, c.nome_categoria, r.qtd_produto, r.val_unitario, r.total_receita
              FROM RECEITA r
              LEFT JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria
              LEFT JOIN PGTO_RECEITA p ON r.id_pgto_receita = p.id_pgto_receita
              ORDER BY r.data_venda DESC
          ";

          $stmt = $conn->query($sql);

          if ($stmt) {
              $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if (count($rows) > 0) {
                  foreach ($rows as $row) {
                      echo "<tr>";
                      echo "<td>" . date("d/m/Y", strtotime($row['data_venda'])) . "</td>";
                      echo "<td>" . htmlspecialchars($row['nome_cliente']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['pagamento']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['nome_produto']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['nome_categoria']) . "</td>";
                      echo "<td>" . intval($row['qtd_produto']) . "</td>";
                      echo "<td>R$ " . number_format($row['val_unitario'], 2, ',', '.') . "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='8'>Nenhum dado encontrado</td></tr>";
              }
          } else {
              echo "<tr><td colspan='8'>Erro na consulta SQL</td></tr>";
          }

          $conn = null;
          ?>
        </tbody>
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

  <script src="../assets/js/inatividade.js"></script>

</body>
</html>
