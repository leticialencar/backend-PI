<?php
require __DIR__ . '/../config/config.php';
$conn = Conexao::getConn();

$produtos = $conn->query("SELECT DISTINCT MONTH(data_conta) AS mes FROM DESPESA_VARIADOS ORDER BY mes")->fetchAll(PDO::FETCH_COLUMN);
$categorias = $conn->query("SELECT DISTINCT valor FROM DESPESA_VARIADOS ORDER BY valor")->fetchAll(PDO::FETCH_COLUMN);
$quantidades = $conn->query("SELECT DISTINCT variado FROM DESPESA_VARIADOS ORDER BY variado")->fetchAll(PDO::FETCH_COLUMN);
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
                <li><a href="despesa_produto.html">Produto</a></li>
                <li class="active"><a href="despesas_variadas.html">Variado</a></li>
            </ul>
        </nav>
    </div>

    <!-- Div de Filtros -->
    <div class="nav-filter-category">
        <div class="filters">
            <input type="date" id="data-filter" name="data">

            <select id="produto-filter" name="produto">
                <option value="">Selecione o Mês</option>
                <?php foreach($produtos as $produto): ?>
                    <option value="<?= htmlspecialchars($produto) ?>"><?= htmlspecialchars($produto) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="categoria-filter" name="categoria">
                <option value="">Selecione o Valor</option>
                <?php foreach($categorias as $categoria): ?>
                    <option value="<?= htmlspecialchars($categoria) ?>">R$ <?= number_format($categoria, 2, ',', '.') ?></option>
                <?php endforeach; ?>
            </select>

            <select id="quantidade-filter" name="quantidade">
                <option value="">Selecione o Variado</option>
                <?php foreach($quantidades as $quantidade): ?>
                    <option value="<?= htmlspecialchars($quantidade) ?>"><?= htmlspecialchars($quantidade) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Tabela de Receitas -->
    <main class="main-tabela">
        <table class="tabela-receitas">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM DESPESA_VARIADOS ORDER BY data_conta DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($result) {
                foreach($result as $row) {
                    echo "<tr>";
                    echo "<td>" . date('Y-m-d', strtotime($row['data_conta'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['variado']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['valor']) . "</td>";
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
                <p>* Selecionar pra excluir</p>
                <button class="btn-imprimir"><i class="fa fa-print"></i> Imprimir</button>
            </div>
        </div>
        <div class="total-gasto-box">
            <p class="total-gasto">TOTAL GASTO: R$ 3000,00</p>
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
    // Abrir e fechar modal
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

    // Filtros
    const dataFilter = document.getElementById('data-filter');
    const produtoFilter = document.getElementById('produto-filter');
    const categoriaFilter = document.getElementById('categoria-filter');
    const quantidadeFilter = document.getElementById('quantidade-filter');
    const tabela = document.querySelector('.tabela-receitas tbody');

    function aplicarFiltros() {
        const data = dataFilter.value;
        const produto = produtoFilter.value;
        const categoria = categoriaFilter.value;
        const quantidade = quantidadeFilter.value;

        tabela.querySelectorAll('tr').forEach(tr => {
            const tds = tr.querySelectorAll('td');

            if(tds.length === 0) return;

            const dataTd = tds[0].textContent.trim();
            const mesTd = new Date(dataTd).getMonth() + 1; 
            const categoriaTd = tds[1].textContent.trim();
            const descricaoTd = tds[2].textContent.trim();
            const valorTd = tds[3].textContent.trim().replace('R$', '').replace(',', '.').trim();

            let mostrar = true;

            if (data && data !== dataTd) mostrar = false;
            if (produto && produto != mesTd) mostrar = false;
            if (categoria && parseFloat(categoria).toFixed(2) != parseFloat(valorTd).toFixed(2)) mostrar = false;
            if (quantidade && quantidade !== categoriaTd) mostrar = false;

            if (mostrar) {
                tr.style.display = '';
            } else {
                tr.style.display = 'none';
            }
        });
    }

    [dataFilter, produtoFilter, categoriaFilter, quantidadeFilter].forEach(f => {
        f.addEventListener('change', aplicarFiltros);
    });
</script>

</body>
</html>
