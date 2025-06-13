<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

try {
    $stmt = $conn->prepare("SELECT id, nome FROM FORNECEDOR ORDER BY nome ASC");
    $stmt->execute();
    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar fornecedores: " . $e->getMessage();
    $fornecedores = [];
}
?>

<!DOCTYPE html> 
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/cadastrar_despesas_produtos.css">
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
                <li><a href="../public/cadastrar_despesas_fixas.php">Fixos</a></li>
                <li class="active"><a href="../public/cadastrar_despesas_produtos.php">Produtos</a></li>
                <li><a href="../public/cadastrar_despesas_variados.php">Variados</li></a>
            </ul>
        </nav>
    </div>

    <main class="main">
        <!-- Modal de Sair -->
        <div class="modal-overlay hidden" id="modal-sair">
            <div class="modal-box">
                <button class="modal-close close-modal close-modal-sair" type="button" aria-label="Fechar modal">
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

        <!-- Modal de Excluir -->
        <div class="modal-overlay hidden" id="modal-excluir-receita">
            <div class="modal-box">
                <button class="modal-close fechar-modal-excluir" type="button" aria-label="Fechar modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="modal-subject">
                    <div class="modal-header">
                        <p class="modal-title">Deseja mesmo <span>excluir</span> essa despesa?</p>
                    </div>
                    <div class="modal-form">
                        <form>
                            <div class="sim-btn">
                               <a href="login.html"><button type="button" id="btn-sim">Sim</button></a>
                            </div>
                            <div class="nao-btn">
                                <button type="button" id="cancelar-exclusao">Não</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="input-receitas">
            <div class="form-title">
                <h2>Cadastrar Despesas</h2>
                <a href="../public/despesa_produto.php"><button type="button" class="ver-despesas">Ver Despesas</button></a>
            </div>

            <form action="../src/despesas/cadastrar-despesa-produto.php" method="post">
                <div class="input-group">
                    <div class="input-box">
                        <label for="data-compra">Data da Compra</label>
                        <input type="date" id="data-compra" name="data-compra" required>
                    </div>

                    <div class="input-box">
                        <label for="validade">Validade</label>
                        <input type="date" id="validade" name="validade" required>
                    </div>

                    <div class="input-box">
                        <label for="nome-produto">Nome do Produto</label>
                        <input type="text" id="nome-produto" name="nome-produto" required>
                    </div>

                    <div class="input-box">
                        <label for="valor-unitario">Valor Unitário</label>
                        <input type="number" id="valor-unitario" name="valor-unitario" min="1" step="1" required>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade</label>
                        <input type="number" id="quantidade" name="quantidade" min="1" step="1" required>
                    </div>

                    <div class="input-box">
                        <label for="fornecedor">Fornecedor</label>
                        <select id="fornecedor" name="id_fornecedor" required>
                        <option value="">Selecione um fornecedor</option>
                        <?php if (!empty($fornecedores)): ?>
                            <?php foreach ($fornecedores as $fornecedor): ?>
                                <option value="<?= htmlspecialchars($fornecedor['id']) ?>">
                                    <?= htmlspecialchars($fornecedor['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Nenhum fornecedor cadastrado</option>
                        <?php endif; ?>
                    </select>
                    </div>

                    <div class="input-box">
                        <label for="total">TOTAL</label>
                        <input type="text" id="total" name="total" readonly>
                    </div>
                </div>

                <div class="criar-btn">
                    <button type="submit" class="btn-cadastrar">Cadastrar</button>
                </div>
            </form>
        </div>
    </main>
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
    const botaoAbrirModalExcluir = document.querySelector(".abrir-modal-excluir");
    botaoAbrirModalExcluir.addEventListener("click", (e) => {
        e.preventDefault();
        const inputs = document.querySelectorAll(".input-group input, .input-group select");
        let isFormValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isFormValid = false;
            }
        });

        if (isFormValid) {
            document.getElementById("modal-excluir-receita").classList.remove("hidden");
        } else {
            alert("Por favor, preencha todos os campos antes de excluir.");
        }
    });

    const form = document.querySelector("form");
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const inputs = document.querySelectorAll(".input-group input, .input-group select");
        let isFormValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isFormValid = false;
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "";
            }
        });

        if (isFormValid) {
            alert("Cadastro realizado com sucesso!");
        } else {
            alert("Por favor, preencha todos os campos antes de cadastrar.");
        }
    });

    const valorUnitario = document.getElementById("valor-unitario");
    const quantidade = document.getElementById("quantidade");
    const total = document.getElementById("total");

    function calcularTotal() {
        const valor = parseFloat(valorUnitario.value);
        const qtd = parseInt(quantidade.value);
        if (!isNaN(valor) && !isNaN(qtd)) {
            total.value = (valor * qtd).toFixed(2);
        } else {
            total.value = "";
        }
    }

    valorUnitario.addEventListener("input", calcularTotal);
    quantidade.addEventListener("input", calcularTotal);
</script>

<script src="../assets/js/inatividade.js"></script>

</body>
</html>
