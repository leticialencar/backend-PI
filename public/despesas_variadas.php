<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';
$conn = Conexao::getConn();

$mesFiltro = $_GET['produto'] ?? '';
$valorFiltro = $_GET['categoria'] ?? '';
$variadoFiltro = $_GET['quantidade'] ?? '';
$dataFiltro = $_GET['data'] ?? '';

$produtos = $conn->query("SELECT DISTINCT MONTH(data_conta) AS mes FROM DESPESA_VARIADOS ORDER BY mes")->fetchAll(PDO::FETCH_COLUMN);
$categorias = $conn->query("SELECT DISTINCT valor FROM DESPESA_VARIADOS ORDER BY valor")->fetchAll(PDO::FETCH_COLUMN);
$quantidades = $conn->query("SELECT DISTINCT variado FROM DESPESA_VARIADOS ORDER BY variado")->fetchAll(PDO::FETCH_COLUMN);

$mesesPt = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];

$sql = "SELECT * FROM DESPESA_VARIADOS WHERE 1=1 ";
$params = [];

if ($mesFiltro !== '') {
    $sql .= " AND MONTH(data_conta) = :mes ";
    $params[':mes'] = $mesFiltro;
}
if ($valorFiltro !== '') {
    $sql .= " AND valor = :valor ";
    $params[':valor'] = $valorFiltro;
}
if ($variadoFiltro !== '') {
    $sql .= " AND variado = :variado ";
    $params[':variado'] = $variadoFiltro;
}
if ($dataFiltro !== '') {
    $sql .= " AND data_conta = :data ";
    $params[':data'] = $dataFiltro;
}

$sql .= " ORDER BY data_conta DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlTotal = "SELECT SUM(valor) AS total FROM DESPESA_VARIADOS WHERE 1=1";
$paramsTotal = [];

if ($mesFiltro !== '') {
    $sqlTotal .= " AND MONTH(data_conta) = :mes ";
    $paramsTotal[':mes'] = $mesFiltro;
}
if ($valorFiltro !== '') {
    $sqlTotal .= " AND valor = :valor ";
    $paramsTotal[':valor'] = $valorFiltro;
}
if ($variadoFiltro !== '') {
    $sqlTotal .= " AND variado = :variado ";
    $paramsTotal[':variado'] = $variadoFiltro;
}
if ($dataFiltro !== '') {
    $sqlTotal .= " AND data_conta = :data ";
    $paramsTotal[':data'] = $dataFiltro;
}

$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->execute($paramsTotal);
$resultTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
$totalFiltrado = $resultTotal['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/despesas_variadas.css">
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
                <li><a href="../public/despesas_fixas.php">Fixos</a></li>
                <li><a href="../public/despesa_produto.php">Produto</a></li>
                <li class="active"><a href="../public/despesas_variadas.php">Variado</a></li>
            </ul>
        </nav>
    </div>

    <div class="nav-filter-category">
    <form id="filtro-form" method="GET">
        <div class="filters">
            <input type="date" id="data-filter" name="data" value="">

            <select id="produto-filter" name="produto">
                <option value="">Mês</option>
                <?php foreach($produtos as $produto): ?>
                    <option value="<?= (int)$produto ?>">
                        <?= $mesesPt[(int)$produto] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="categoria-filter" name="categoria">
                <option value="">Valor</option>
                <?php foreach($categorias as $categoria): ?>
                    <option value="<?= number_format($categoria, 2, '.', '') ?>">
                        R$ <?= number_format($categoria, 2, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="quantidade-filter" name="quantidade">
                <option value="">Variado</option>
                <?php foreach($quantidades as $quantidade): ?>
                    <option value="<?= htmlspecialchars($quantidade) ?>">
                        <?= htmlspecialchars($quantidade) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

    <main class="main-tabela">
        <table class="tabela-receitas">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Variado</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($result) {
                foreach($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($row['data_conta']))) . "</td>";
                    echo "<td>" . htmlspecialchars($row['variado']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                    echo "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhuma despesa encontrada.</td></tr>";
            }
            ?>
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
            TOTAL GASTO: R$ <?= number_format($totalFiltrado, 2, ',', '.') ?>
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

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filtro-form');
        if (!form) return;

        form.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>

<script>
document.querySelector('.btn-imprimir').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');

    const titulo = 'Relatório de Despesas Variadas';
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
            halign: 'center'
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
