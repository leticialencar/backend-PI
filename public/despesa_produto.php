<?php
require __DIR__ . '/../config/config.php'; // Ajuste o caminho conforme sua estrutura

$conn = Conexao::getConn();

try {
    $sql = "SELECT dp.data_compra, f.nome AS fornecedor, dp.nome_produto, dp.qtd_produto, dp.val_unitario, dp.total_despesa, dp.validade
            FROM DESPESA_PRODUTO dp
            LEFT JOIN FORNECEDOR f ON dp.id_fornecedor = f.id
            ORDER BY dp.data_compra DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <li><a href="despesas_variadas.php">Variados</a></li>
                </ul>
            </nav>
        </div>

        <!-- Div de Filtros -->
        <div class="nav-filter-category">
            <div class="filters">
                <input type="date" id="data-filter" name="data">

                <select id="pagamento-filter" name="pagamento">
                    <option value="pagamento">Janeiro</option>
                    <option value="pagamento1"></option>
                    <option value="pagamento2"></option>
                    <option value="pagamento"></option>
                </select>

                <select id="produto-filter" name="produto">
                    <option value="produto">Nome cliente</option>
                    <option value="produto1"></option>
                    <option value="produto2"></option>
                    <option value="produto3"></option>
                </select>

                <select id="categoria-filter" name="categoria">
                    <option value="categoria">Quantidade</option>
                    <option value="categoria1"></option>
                    <option value="categoria2"></option>
                    <option value="categoria3"></option>
                </select>

                <select id="quandtidade-filter" name="quantidade">
                    <option value="quantidade">Validade</option>
                    <option value="quantidade1"></option>
                    <option value="quantidade2"></option>
                    <option value="quantidade3"></option>
                </select>

                <select id="valor-unit-filter" name="valor-unit">
                    <option value="valor-unit">Fornecedor</option>
                    <option value="valor-unit1"></option>
                    <option value="valor-unit2"></option>
                    <option value="valor-unit3"></option>
                </select>
            </div>
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
                        <tr><td colspan="7" style="text-align:center;">Nenhum registro encontrado.</td></tr>
                    <?php endif; ?>
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
                <p class="total-gasto">TOTAL GASTO: R$ 3000,00</p>
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

</body>

</html>
