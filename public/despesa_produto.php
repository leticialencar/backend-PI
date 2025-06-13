<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

function normalizaData(string $date): ?string
{

    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return $date;
    }

    $d = DateTime::createFromFormat('d/m/Y', $date);
    return $d ? $d->format('Y-m-d') : null;
}

try {

    $where = [];
    $params = [];

    if (!empty($_GET['fornecedor'])) {
        $where[] = 'f.nome = :fornecedor';
        $params[':fornecedor'] = $_GET['fornecedor'];
    }

    if (!empty($_GET['produto'])) {
        $where[] = 'dp.nome_produto = :produto';
        $params[':produto'] = $_GET['produto'];
    }

    if (!empty($_GET['quantidade'])) {
        $where[] = 'dp.qtd_produto = :quantidade';
        $params[':quantidade'] = $_GET['quantidade'];
    }

    if (!empty($_GET['validade'])) {
        $where[] = 'dp.validade = :validade';
        $params[':validade'] = $_GET['validade'];
    }

    if (!empty($_GET['mes'])) {
        $where[] = 'MONTH(dp.data_compra) = :mes';
        $params[':mes'] = $_GET['mes'];
    }

    if (!empty($_GET['data'])) {
        $dataSql = normalizaData($_GET['data']);
        if ($dataSql) {
            $where[] = 'dp.data_compra = :data_compra';
            $params[':data_compra'] = $dataSql;
        }
    }

    $sql = "SELECT dp.data_compra, f.nome AS fornecedor, dp.nome_produto, dp.qtd_produto, dp.val_unitario, dp.total_despesa, dp.validade
            FROM DESPESA_PRODUTO dp
            LEFT JOIN FORNECEDOR f ON dp.id_fornecedor = f.id";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY dp.data_compra DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalFiltrado = 0;
    foreach ($despesas as $dp) {
        $totalFiltrado += (float)$dp['total_despesa'];
    }

    $fornecedores = $conn->query("SELECT DISTINCT f.nome FROM FORNECEDOR f INNER JOIN DESPESA_PRODUTO dp ON dp.id_fornecedor = f.id")
                         ->fetchAll(PDO::FETCH_COLUMN);

    $produtos = $conn->query("SELECT DISTINCT nome_produto FROM DESPESA_PRODUTO")
                     ->fetchAll(PDO::FETCH_COLUMN);

    $quantidades = $conn->query("SELECT DISTINCT qtd_produto FROM DESPESA_PRODUTO ORDER BY qtd_produto")
                        ->fetchAll(PDO::FETCH_COLUMN);

    $validades = $conn->query("SELECT DISTINCT validade FROM DESPESA_PRODUTO ORDER BY validade DESC")
                      ->fetchAll(PDO::FETCH_COLUMN);

    $meses = $conn->query("SELECT DISTINCT MONTH(data_compra) as mes FROM DESPESA_PRODUTO ORDER BY mes")
                  ->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CashHive System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/despesa_produto.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <li class="active"><a href="despesa_produto.php">Produto</a></li>
                    <li><a href="../public/despesas_variadas.php">Variados</a></li>
                </ul>
            </nav>
        </div>

        <!-- Div de Filtros -->
        <div class="nav-filter-category">
            <form id="filtro-form" method="GET">
                <div class="filters">

                    <input type="date" name="data" value="<?= htmlspecialchars($filtroDataPagamento) ?>" />

                    <select id="pagamento-filter" name="mes">
                        <option value="">Mês</option>
                            <?php 
                            $nomesMeses = [1=>'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
                            foreach ($meses as $m): ?>
                                <option value="<?= $m ?>"><?= $nomesMeses[(int)$m] ?></option>
                            <?php endforeach; ?>
                    </select>

                    <select id="produto-filter" name="produto">
                        <option value="">Produto</option>
                        <?php foreach ($produtos as $p): ?>
                            <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select id="categoria-filter" name="quantidade">
                        <option value="">Quantidade</option>
                        <?php foreach ($quantidades as $q): ?>
                            <option value="<?= $q ?>"><?= $q ?></option>
                        <?php endforeach; ?>
                    </select>

                <select id="quandtidade-filter" name="validade">
                    <option value="">Validade</option>
                    <?php foreach ($validades as $v): ?>
                        <option value="<?= $v ?>"><?= date("d/m/Y", strtotime($v)) ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="valor-unit-filter" name="fornecedor">
                    <option value="">Fornecedor</option>
                    <?php foreach ($fornecedores as $f): ?>
                        <option value="<?= htmlspecialchars($f) ?>"><?= htmlspecialchars($f) ?></option>
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
                        <th>Data da compra</th>
                        <th>Fornecedor</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor unitário</th>
                        <th>Total</th>
                        <th>Validade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($despesas)): ?>
                        <?php foreach ($despesas as $dp): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($dp['data_compra'])) ?></td>
                                <td><?= htmlspecialchars($dp['fornecedor'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($dp['nome_produto']) ?></td>
                                <td><?= (int)$dp['qtd_produto'] ?> unid</td>
                                <td>R$ <?= number_format($dp['val_unitario'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($dp['total_despesa'], 2, ',', '.') ?></td>
                                <td><?= $dp['validade'] ? date('d/m/Y', strtotime($dp['validade'])) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center;">Nenhuma despesa encontrada para os filtros selecionados.</td></tr>
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
                <p class="total-gasto">
                    TOTAL GASTO: R$ <?= number_format($totalFiltrado, 2, ',', '.') ?>
                </p>
            </div>
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

    const titulo = 'Relatório de Despesas de Produtos';
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
