<?php
include '../src/login/verify-session.php';
include __DIR__ . '/../config/config.php';

$user_id = $_SESSION['id_usuario'] ?? null;
if (!$user_id) {
    header('Location: login.html');
    exit;
}

$conn = Conexao::getConn();

$mesAtual = date('m');
$anoAtual = date('Y');

// Total receitas (tabela RECEITA)
$stmt = $conn->prepare("SELECT SUM(total_receita) as total FROM RECEITA WHERE MONTH(data_venda) = ? AND YEAR(data_venda) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$totalReceitas = $stmt->fetchColumn() ?: 0;

// Total despesas (somando todas as tabelas de despesas)
$totalDespesas = 0;

// DESPESAS_FIXAS
$stmt = $conn->prepare("SELECT SUM(valor) FROM DESPESAS_FIXAS WHERE MONTH(data_conta) = ? AND YEAR(data_conta) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$totalDespesas += $stmt->fetchColumn() ?: 0;

// DESPESA_PRODUTO
$stmt = $conn->prepare("SELECT SUM(total_despesa) FROM DESPESA_PRODUTO WHERE MONTH(data_compra) = ? AND YEAR(data_compra) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$totalDespesas += $stmt->fetchColumn() ?: 0;

// DESPESA_VARIADOS
$stmt = $conn->prepare("SELECT SUM(valor) FROM DESPESA_VARIADOS WHERE MONTH(data_conta) = ? AND YEAR(data_conta) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$totalDespesas += $stmt->fetchColumn() ?: 0;

$saldo = $totalReceitas - $totalDespesas;

$movimentacoes = [];

$stmt = $conn->prepare("SELECT 'Receita' as tipo, nome_produto as descricao, total_receita as valor, data_venda as data FROM RECEITA WHERE MONTH(data_venda) = ? AND YEAR(data_venda) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$movimentacoes = array_merge($movimentacoes, $stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->prepare("SELECT 'Despesa Fixa' as tipo, descricao, valor, data_conta as data FROM DESPESAS_FIXAS WHERE MONTH(data_conta) = ? AND YEAR(data_conta) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$movimentacoes = array_merge($movimentacoes, $stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->prepare("SELECT 'Despesa Produto' as tipo, nome_produto as descricao, total_despesa as valor, data_compra as data FROM DESPESA_PRODUTO WHERE MONTH(data_compra) = ? AND YEAR(data_compra) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$movimentacoes = array_merge($movimentacoes, $stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->prepare("SELECT 'Despesa Variada' as tipo, descricao, valor, data_conta as data FROM DESPESA_VARIADOS WHERE MONTH(data_conta) = ? AND YEAR(data_conta) = ?");
$stmt->execute([$mesAtual, $anoAtual]);
$movimentacoes = array_merge($movimentacoes, $stmt->fetchAll(PDO::FETCH_ASSOC));

usort($movimentacoes, function($a, $b) {
    return strtotime($b['data']) - strtotime($a['data']);
});
$movimentacoes = array_slice($movimentacoes, 0, 5);

$metaReceita = 5000; 
$metaDespesa = 3000;
$progressoReceita = min(100, $metaReceita > 0 ? round(($totalReceitas / $metaReceita) * 100) : 0);
$progressoDespesa = min(100, $metaDespesa > 0 ? round(($totalDespesas / $metaDespesa) * 100) : 0);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashHive System - Página Inicial</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/homepage.css">
    <link rel="stylesheet" href="../assets/css/toast.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/modalsair.css">
    <style>
        .dashboard-cards { display: flex; gap: 2rem; margin-bottom: 2rem; }
        .dashboard-card { flex: 1; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #0001; padding: 1.5rem; }
        .dashboard-card h3 { margin: 0 0 1rem 0; font-size: 1.2rem; }
        .saldo { font-size: 2rem; font-weight: bold; color: #2e7d32; }
        .barra-status { background: #eee; border-radius: 8px; height: 18px; margin: 0.5rem 0 1rem 0; position: relative; }
        .barra-status-inner { height: 100%; border-radius: 8px; transition: width 0.5s; }
        .barra-receita { background: #4caf50; }
        .barra-despesa { background: #e53935; }
        .barra-status span { position: absolute; right: 10px; top: 0; font-size: 0.9rem; color: #333; }
        .ultimas-movimentacoes { margin-top: 2rem; }
        .ultimas-movimentacoes table { width: 100%; border-collapse: collapse; }
        .ultimas-movimentacoes th, .ultimas-movimentacoes td { padding: 0.5rem; text-align: left; }
        .ultimas-movimentacoes th { background: #f5f5f5; }
        .ultimas-movimentacoes tr:nth-child(even) { background: #fafafa; }
        .tipo-receita { color: #388e3c; font-weight: bold; }
        .tipo-despesa { color: #d32f2f; font-weight: bold; }
        .detalhe-btn { background: #1976d2; color: #fff; border: none; border-radius: 5px; padding: 0.3rem 0.8rem; cursor: pointer; }
        .detalhe-btn:hover { background: #1565c0; }
        .saldo-negativo { color: #d32f2f; }
        .tooltip { position: relative; cursor: pointer; }
        .tooltip .tooltiptext {
            visibility: hidden; width: 180px; background: #333; color: #fff; text-align: center;
            border-radius: 6px; padding: 5px 0; position: absolute; z-index: 1; bottom: 125%; left: 50%;
            margin-left: -90px; opacity: 0; transition: opacity 0.3s;
        }
        .tooltip:hover .tooltiptext { visibility: visible; opacity: 1; }
    </style>
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
                        <button class="btn-sair-conta open-modal" data-modal="modal-1">Sair</button>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard">
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <h3>
                        <span class="tooltip">Receitas do mês
                            <span class="tooltiptext">Total de receitas cadastradas neste mês</span>
                        </span>
                    </h3>
                    <div class="saldo">R$ <?= number_format($totalReceitas, 2, ',', '.') ?></div>
                    <div class="barra-status">
                        <div class="barra-status-inner barra-receita" style="width: <?= $progressoReceita ?>%"></div>
                        <span><?= $progressoReceita ?>% da meta (<?= number_format($metaReceita, 2, ',', '.') ?>)</span>
                    </div>
                </div>
                <div class="dashboard-card">
                    <h3>
                        <span class="tooltip">Despesas do mês
                            <span class="tooltiptext">Total de despesas cadastradas neste mês</span>
                        </span>
                    </h3>
                    <div class="saldo saldo-negativo">R$ <?= number_format($totalDespesas, 2, ',', '.') ?></div>
                    <div class="barra-status">
                        <div class="barra-status-inner barra-despesa" style="width: <?= $progressoDespesa ?>%"></div>
                        <span><?= $progressoDespesa ?>% da meta (<?= number_format($metaDespesa, 2, ',', '.') ?>)</span>
                    </div>
                </div>
                <div class="dashboard-card">
                    <h3>
                        <span class="tooltip">Saldo do mês
                            <span class="tooltiptext">Receitas menos despesas</span>
                        </span>
                    </h3>
                    <div class="saldo <?= $saldo < 0 ? 'saldo-negativo' : '' ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></div>
                </div>
            </div>

            <section class="ultimas-movimentacoes">
                <h3>Últimas movimentações</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($movimentacoes) === 0): ?>
                            <tr><td colspan="5">Nenhuma movimentação encontrada.</td></tr>
                        <?php else: ?>
                            <?php foreach ($movimentacoes as $mov): ?>
                                <tr>
                                    <td class="<?= $mov['tipo'] === 'Receita' ? 'tipo-receita' : 'tipo-despesa' ?>">
                                        <?= htmlspecialchars($mov['tipo']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($mov['descricao']) ?></td>
                                    <td>R$ <?= number_format($mov['valor'], 2, ',', '.') ?></td>
                                    <td><?= date('d/m/Y', strtotime($mov['data'])) ?></td>
                                    <td>
                                        <button class="detalhe-btn" onclick="mostrarDetalhes('<?= htmlspecialchars(addslashes($mov['tipo'])) ?>', '<?= htmlspecialchars(addslashes($mov['descricao'])) ?>', '<?= number_format($mov['valor'], 2, ',', '.') ?>', '<?= date('d/m/Y', strtotime($mov['data'])) ?>')">
                                            Detalhes
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div class="modal-overlay hidden" id="modal-1">
        <div class="modal-box">
            <button class="modal-close close-modal" type="button">
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
                            <button type="button" class="close-modal">Não</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="session-expired-toast" class="toast hidden">
        Sua sessão expirou! Faça o login novamente.
    </div>

    <!-- Modal de detalhes -->
    <div id="modal-detalhes" class="modal-overlay hidden">
        <div class="modal-box">
            <button class="modal-close close-modal-detalhes" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="modal-detalhes-subject">
                <div class="modal-header">
                    <h3>Detalhes da Movimentação</h3>
                </div>
                <div class="modal-body" id="detalhes-body">
                    <!-- Conteúdo preenchido via JS -->
                </div>
            </div>

        </div>
    </div>

    <script>
        // Modal sair
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

        // Modal detalhes
        function mostrarDetalhes(tipo, descricao, valor, data) {
            document.getElementById('detalhes-body').innerHTML =
                `<p><strong>Tipo:</strong> ${tipo}</p>
                 <p><strong>Descrição:</strong> ${descricao}</p>
                 <p><strong>Valor:</strong> R$ ${valor}</p>
                 <p><strong>Data:</strong> ${data}</p>`;
            document.getElementById('modal-detalhes').classList.remove('hidden');
        }
        document.querySelectorAll(".close-modal-detalhes").forEach(button => {
            button.addEventListener("click", () => {
                button.closest(".modal-overlay").classList.add("hidden");
            });
        });
    </script>
    <script src="../assets/js/inatividade.js"></script>
</body>
</html>
