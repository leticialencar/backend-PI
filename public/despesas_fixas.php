<?php 
include '../src/login/verify-session.php'; 

require __DIR__ . '/../config/config.php';
$conn = Conexao::getConn();

$sql = "SELECT df.data_pagamento, df.categoria, fp.descricao AS forma_pagamento, df.data_conta, df.valor, df.descricao FROM despesas_fixas df LEFT JOIN formas_pagamento fp ON fp.id_forma_pagamento = df.id_forma_pagamento";

$stmt = $conn->prepare($sql);
$stmt->execute();
$despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlClientes = "SELECT DISTINCT data_pagamento FROM despesas_fixas ORDER BY data_pagamento";
$stmtClientes = $conn->prepare($sqlClientes);
$stmtClientes->execute();
$dataPagamentos = $stmtClientes->fetchAll(PDO::FETCH_COLUMN);

$sqlCategorias = "SELECT DISTINCT categoria FROM despesas_fixas ORDER BY categoria";
$stmtCategorias = $conn->prepare($sqlCategorias);
$stmtCategorias->execute();
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_COLUMN);

$sqlFormasPagamento = "SELECT DISTINCT descricao FROM formas_pagamento ORDER BY descricao";
$stmtFormasPagamento = $conn->prepare($sqlFormasPagamento);
$stmtFormasPagamento->execute();
$formasPagamento = $stmtFormasPagamento->fetchAll(PDO::FETCH_COLUMN);

$sqlDatasVencimento = "SELECT DISTINCT data_conta FROM despesas_fixas ORDER BY data_conta";
$stmtDatasVencimento = $conn->prepare($sqlDatasVencimento);
$stmtDatasVencimento->execute();
$datasVencimento = $stmtDatasVencimento->fetchAll(PDO::FETCH_COLUMN);

$sqlValores = "SELECT DISTINCT valor FROM despesas_fixas ORDER BY valor";
$stmtValores = $conn->prepare($sqlValores);
$stmtValores->execute();
$valores = $stmtValores->fetchAll(PDO::FETCH_COLUMN);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/despesa-fixas.css">
  <link rel="stylesheet" href="../assets/css/toast.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../assets/css/modalsair.css">
</head>
<body>

<header class="container-header">
  <div class="logo">
    <img src="../assets/img/logo.png" alt="Logo CashHive">
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
          <img src="../assets/img/homeicon.svg" alt="Início">
          <a href="homepage.html">Página inicial</a>
        </li>
        <li>
          <img src="../assets/img/profileicon.svg" alt="Perfil">
          <a href="../public/profile.php">Perfil</a>
        </li>
        <li>
          <details class="submenu">
            <summary>
              <img src="../assets/img/financeicon.svg" alt="Financeiro">
              Financeiro
            </summary>
            <ul>
              <li><a href="../public/cadastrar_funcionario.php">Funcionário</a></li>
              <li><a href="../public/receitas_kibon.php">Receitas</a></li>
              <li><a href="../public/cadastrar_receitas.php">Cadastro de Receitas</a></li>
              <li><a href="../public/despesas_fixas.php">Despesas</a></li>
              <li><a href="../public/cadastrar_despesas_fixas.php">Cadastro de Despesas</a></li>
            </ul>
          </details>
        </li>
        <li class="logout">
          <img src="../assets/img/logouticon.svg" alt="Sair">
          <button class="open-modal" data-modal="modal-sair">Sair</button>
        </li>
      </ul>
    </nav>
  </aside>

  <div class="nav-category">
    <nav class="nav-options">
      <ul>
        <li class="active"><a href="../public/despesas_fixas.php">Fixos</a></li>
        <li><a href="despesa_produto.html">Produto</a></li>
        <li><a href="despesas_variadas.html">Variados</a></li>
      </ul>
    </nav>
  </div>

  <div class="nav-filter-category">
        <div class="filters">

            <select id="cliente-filter" name="cliente">
            <option value="">Data de Pagamento</option>
            <?php foreach ($dataPagamentos as $data): ?>
                <option value="<?= htmlspecialchars($data) ?>"><?= date('d/m/Y', strtotime($data)) ?></option>
            <?php endforeach; ?>
            </select>

            <select id="pagamento-filter" name="pagamento">
                <option value="">Categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= htmlspecialchars($categoria) ?>"><?= htmlspecialchars($categoria) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="produto-filter" name="produto">
                <option value="">Forma de pagamento</option>
                <?php foreach ($formasPagamento as $forma): ?>
                    <option value="<?= htmlspecialchars($forma) ?>"><?= htmlspecialchars($forma) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="quandtidade-filter" name="quantidade">
                <option value="">Data de Vencimento</option>
                <?php foreach ($datasVencimento as $data): ?>
                    <option value="<?= htmlspecialchars($data) ?>"><?= date('d/m/Y', strtotime($data)) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="valor-unit-filter" name="valor-unit">
                <option value="">Valor</option>
                <?php foreach ($valores as $valor): ?>
                    <option value="<?= htmlspecialchars($valor) ?>">R$ <?= number_format($valor, 2, ',', '.') ?></option>
                <?php endforeach; ?>
            </select>
      </div>
    </div>

  <main class="main-tabela">
        <table class="tabela-receitas">
            <thead>
                <tr>
                    <th>Data de Pagamento</th>
                    <th>Categoria</th>
                    <th>Forma de Pagamento</th>
                    <th>Data de Vencimento</th>
                    <th>Valor</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($despesas as $despesa): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($despesa['data_pagamento'])) ?></td>
                    <td><?= htmlspecialchars($despesa['categoria']) ?></td>
                    <td><?= htmlspecialchars($despesa['forma_pagamento']) ?></td>
                    <td><?= date('d/m/Y', strtotime($despesa['data_conta'])) ?></td>
                    <td>R$ <?= number_format($despesa['valor'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($despesa['descricao']) ?></td>
                </tr>
            <?php endforeach; ?>
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
    <p class="total-gasto">
        TOTAL GASTO: R$
        <?php
            $sql = "SELECT SUM(valor) AS total FROM DESPESAS_FIXAS";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total = $result['total'] ?? 0;

            echo number_format($total, 2, ',', '.');
        ?>
    </p>
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
  </main>
</div>
<script>
    // Abre o modal ao clicar no botão com data-modal
        document.querySelectorAll(".open-modal").forEach(button => {
            button.addEventListener("click", () => {
                const modalId = button.getAttribute("data-modal");
                document.getElementById(modalId).classList.remove("hidden");
            });
        });
    
        // Fecha o modal ao clicar no botão de fechar ou no botão "Não"
        document.querySelectorAll(".close-modal, #btn-nao").forEach(button => {
            button.addEventListener("click", () => {
                button.closest(".modal-overlay").classList.add("hidden");
            });
        });
    
        // Fecha ao clicar fora da caixa
        window.addEventListener("click", (e) => {
            if (e.target.classList.contains("modal-overlay")) {
                e.target.classList.add("hidden");
            }
        });
</script>

<div id="session-expired-toast" class="toast hidden">
    Sua sessão expirou! Faça o login novamente.
    </div>

    <script>
        document.querySelectorAll(".open-modal").forEach(button => {
            button.addEventListener("click", () => {
                const modalId = button.getAttribute("data-modal");
                document.getElementById(modalId).classList.remove("hidden");
            });
        });
    
        document.querySelectorAll(".close-modal").forEach(button => {
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
    
    <!--- script para inatividade --->
    
    <script>
    const tempoInatividade = 10000;
    let timeout;

    function mostrarToastESair() {
        const toast = document.getElementById("session-expired-toast");
        toast.classList.remove("hidden");
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
            toast.classList.add("hidden");
            window.location.href = '../public/login.html';
        }, 3000);
    }

    function iniciarTemporizador() {
        clearTimeout(timeout);
        timeout = setTimeout(mostrarToastESair, tempoInatividade);
    }

    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evento => {
        document.addEventListener(evento, iniciarTemporizador);
    });

    iniciarTemporizador();
    </script>

</body>
</html>
