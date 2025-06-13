<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';

try {
    $conn = Conexao::getConn();
    $nomeProduto = 'Nestlé';

    $stmt = $conn->prepare("SELECT DISTINCT nome_cliente FROM RECEITA WHERE nome_produto = :produto AND nome_cliente IS NOT NULL ORDER BY nome_cliente");
    $stmt->execute(['produto' => $nomeProduto]);
    $clientes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT f.descricao FROM RECEITA r JOIN FORMAS_PAGAMENTO f ON r.id_forma_pagamento = f.id_forma_pagamento WHERE r.nome_produto = :produto ORDER BY f.descricao");
    $stmt->execute(['produto' => $nomeProduto]);
    $pagamentos = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT c.nome_categoria FROM RECEITA r JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria WHERE r.nome_produto = :produto ORDER BY c.nome_categoria");
    $stmt->execute(['produto' => $nomeProduto]);
    $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT s.nome_sabor FROM RECEITA r JOIN SABOR_PRODUTO s ON r.id_sabor = s.id_sabor WHERE r.nome_produto = :produto ORDER BY s.nome_sabor");
    $stmt->execute(['produto' => $nomeProduto]);
    $sabores = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT qtd_produto FROM RECEITA WHERE nome_produto = :produto ORDER BY qtd_produto");
    $stmt->execute(['produto' => $nomeProduto]);
    $quantidades = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT val_unitario FROM RECEITA WHERE nome_produto = :produto ORDER BY val_unitario");
    $stmt->execute(['produto' => $nomeProduto]);
    $valoresUnit = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $conn->prepare("SELECT DISTINCT total_receita FROM RECEITA WHERE nome_produto = :produto ORDER BY total_receita");
    $stmt->execute(['produto' => $nomeProduto]);
    $totais = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $baseSql = "SELECT r.data_venda, r.nome_cliente, f.descricao AS forma_pagamento, r.nome_produto, c.nome_categoria, s.nome_sabor, r.qtd_produto, r.val_unitario, r.total_receita
        FROM RECEITA r
        LEFT JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria
        LEFT JOIN SABOR_PRODUTO s ON r.id_sabor = s.id_sabor
        LEFT JOIN FORMAS_PAGAMENTO f ON r.id_forma_pagamento = f.id_forma_pagamento
        WHERE r.nome_produto = :produto";

    $params = ['produto' => $nomeProduto];
    $filtros = [];

    if (!empty($_GET['data'])) {
        $filtros[] = 'r.data_venda = :data';
        $params['data'] = $_GET['data'];
    }

    if (!empty($_GET['cliente'])) {
        $filtros[] = 'r.nome_cliente = :cliente';
        $params['cliente'] = $_GET['cliente'];
    }

    if (!empty($_GET['pagamento'])) {
        $filtros[] = 'f.descricao = :pagamento';
        $params['pagamento'] = $_GET['pagamento'];
    }

    if (!empty($_GET['categoria'])) {
        $filtros[] = 'c.nome_categoria = :categoria';
        $params['categoria'] = $_GET['categoria'];
    }

    if (!empty($_GET['sabor'])) {
        $filtros[] = 's.nome_sabor = :sabor';
        $params['sabor'] = $_GET['sabor'];
    }

    if (!empty($_GET['quantidade'])) {
        $filtros[] = 'r.qtd_produto = :quantidade';
        $params['quantidade'] = $_GET['quantidade'];
    }

    if (!empty($_GET['valor_unit'])) {
        $filtros[] = 'r.val_unitario = :valor_unit';
        $params['valor_unit'] = $_GET['valor_unit'];
    }

    if (!empty($_GET['total'])) {
        $filtros[] = 'r.total_receita = :total';
        $params['total'] = $_GET['total'];
    }

    if ($filtros) {
        $baseSql .= ' AND ' . implode(' AND ', $filtros);
    }

    $baseSql .= ' ORDER BY r.data_venda DESC';

    $stmt = $conn->prepare($baseSql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT SUM(r.total_receita) FROM RECEITA r
        LEFT JOIN CATEGORIA_RECEITA c ON r.id_categoria = c.id_categoria
        LEFT JOIN SABOR_PRODUTO s ON r.id_sabor = s.id_sabor
        LEFT JOIN FORMAS_PAGAMENTO f ON r.id_forma_pagamento = f.id_forma_pagamento
        WHERE r.nome_produto = :produto";

    if ($filtros) {
        $sqlTotal .= ' AND ' . implode(' AND ', $filtros);
    }

    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->execute($params);
    $totalReceitaFiltrada = $stmtTotal->fetchColumn() ?? 0;

} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/receitas_nestle.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
          <a href="../public/homepage.php">Página inicial</a>
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
        <li><a href="../public/receitas_kibon.php">Kibon</a></li>
        <li class="active"><a href="../public/receitas_nestle.php">Nestlé</a></li>
        <li><a href="../public/receitas_mareni.php">Mareni</a></li>
      </ul>
    </nav>
  </div>

  <div class="nav-filter-category">
    <form id="filtro-form" method="GET">
      <div class="filters">
        <input type="date" id="data-filter" name="data">

        <select id="cliente-filter" name="cliente">
        <option value="">Cliente</option>
          <?php foreach ($clientes as $cliente): ?>
            <option value="<?= $cliente ?>"><?= $cliente ?></option>
          <?php endforeach; ?>
        </select>

        <select id="pagamento-filter" name="pagamento">
          <option value="">Pagamento</option>
          <?php foreach ($pagamentos as $pagamento): ?>
            <option value="<?= $pagamento ?>"><?= $pagamento ?></option>
          <?php endforeach; ?>
        </select>

        <select id="categoria-filter" name="categoria">
          <option value="">Categoria</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria ?>"><?= $categoria ?></option>
          <?php endforeach; ?>
        </select>

        <select id="sabor-filter" name="sabor">
          <option value="">Sabor</option>
          <?php foreach ($sabores as $sabor): ?>
            <option value="<?= $sabor ?>"><?= $sabor ?></option>
          <?php endforeach; ?>
        </select>

        <select id="quantidade-filter" name="quantidade">
          <option value="">Quantidade</option>
          <?php foreach ($quantidades as $q): ?>
            <option value="<?= $q ?>"><?= $q ?></option>
          <?php endforeach; ?>
        </select>

        <select id="valor-unit-filter" name="valor_unit">
          <option value="">Valor Unitário</option>
          <?php foreach ($valoresUnit as $vu): ?>
            <option value="<?= $vu ?>">R$ <?= number_format($vu, 2, ',', '.') ?></option>
          <?php endforeach; ?>
        </select>

        <select id="total-filter" name="total">
          <option value="">Total</option>
          <?php foreach ($totais as $total): ?>
            <option value="<?= $total ?>">R$ <?= number_format($total, 2, ',', '.') ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>
  </div>

  <main class="main-tabela">
    <table class="tabela-receitas" id="tabela-dados">
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
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($row['data_venda'])) ?></td>
            <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
            <td><?= htmlspecialchars($row['forma_pagamento']) ?></td>
            <td><?= htmlspecialchars($row['nome_produto']) ?></td>
            <td><?= htmlspecialchars($row['nome_categoria']) ?></td>
            <td><?= htmlspecialchars($row['nome_sabor']) ?></td>
            <td><?= htmlspecialchars($row['qtd_produto']) ?></td>
            <td>R$ <?= number_format($row['val_unitario'], 2, ',', '.') ?></td>
            <td>R$ <?= number_format($row['total_receita'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="8" style="text-align: center;">Nenhum resultado encontrado para o filtro especificado.</td>
        </tr>
      <?php endif; ?>
    </tbody>

    </table>
  </main>

  
  <div class="final-tabela">
      <div class="acoes">
          <div class="botoes">
              <button class="btn-imprimir"><i class="fa fa-print"></i> Imprimir</button>
          </div>
      </div>
      <div class="total-gasto-box">
          <p class="total-gasto">TOTAL GANHO: R$ <?= number_format($totalReceitaFiltrada, 2, ',', '.') ?></p>
      </div>
  </div>

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
          <form action="../src/login/logout.php" method="post">
            <div class="sim-btn">
              <button type="submit">Sim</button>
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
<script>
     document.querySelectorAll(".open-modal").forEach(button => {
        button.addEventListener("click", () => {
            const modalId = button.getAttribute("data-modal");
            document.getElementById(modalId).classList.remove("hidden");
        });
    });

    document.querySelectorAll(".close-modal, #btn-nao").forEach(button => {
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

  <script>
document.querySelector('.btn-imprimir').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');

    const titulo = 'Relatório de Receitas - Nestlé';
    const dataHora = new Date();
    const dataFormatada = dataHora.toLocaleDateString();
    const horaFormatada = dataHora.toLocaleTimeString();

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(13);
    doc.setTextColor(0);
    doc.text(titulo, 105, 20, { align: 'center' });

    doc.setFontSize(9);
    doc.setFont('helvetica', 'normal');
    doc.text(`Gerado em: ${dataFormatada} às ${horaFormatada}`, 190, 27, { align: 'right' });

    doc.setDrawColor(180);
    doc.setLineWidth(0.2);
    doc.line(20, 30, 190, 30);

    const tabela = document.querySelector('.tabela-receitas');

    doc.autoTable({
        html: tabela,
        startY: 35,
        styles: {
            font: 'helvetica',
            fontSize: 7,
            cellPadding: 3,
            textColor: 0,
            valign: 'middle',
        },
        headStyles: {
            fillColor: [230, 230, 230],
            textColor: 0,
            fontStyle: 'bold',
            halign: 'center',
        },
        bodyStyles: {
            halign: 'center'
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        tableLineColor: [200, 200, 200],
        tableLineWidth: 0.1,
        margin: { top: 35 },
        didDrawPage: function (data) {
            const pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
            doc.setFontSize(9);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(100);
            doc.text('CashHive System - 2025', doc.internal.pageSize.getWidth() / 2, pageHeight - 10, { align: 'center' });
        }
    });

    const blob = doc.output('blob');
    const url = URL.createObjectURL(blob);
    window.open(url, '_blank');
});
</script>
  
  <script src="../assets/js/inatividade.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

</body>
</html>
