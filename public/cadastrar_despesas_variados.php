<?php include '../src/login/verify-session.php'; ?>

<!DOCTYPE html> 
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/cadastrar_despesas_variados.css">
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
                <li><a href="../public/cadastrar_despesas_produtos.php">Produtos</a></li>
                <li class="active"><a href="../public/cadastrar_despesas_variados.html">Variados</a></li>
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

        <div class="input-receitas">
            <div class="form-title">
                <h2>Cadastrar Despesas</h2>
                <a href="../public/despesas_variadas.php"><button type="button" class="ver-despesas">Ver Despesas</button></a>
            </div>

            <form action="../src/despesas/cadastrar-despesa-variados.php" method="POST">
                <div class="input-group">
                    <div class="input-box">
                        <label for="data-conta">Data da Conta</label>
                        <input type="date" id="data-conta" name="data-conta" required>
                    </div>
                    <div class="input-box">
                        <label for="descricao">Descrição</label>
                        <input type="text" id="descricao" name="descricao" required>
                    </div>
                    <div class="input-box">
                        <label for="variado">Variado</label>
                        <input type="text" id="variado" name="variado" required>
                    </div>
                    <div class="input-box">
                        <label for="valor">Valor</label>
                        <input type="number" id="valor" name="valor" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="criar-btn">
                    <button type="submit" class="btn-cadastrar">Cadastrar</button>
                </div>
            </form>
        </div>
    </main>
</div>

<div class="modal-overlay hidden" id="modal-excluir-receita">
    <div class="modal-box">
        <button class="modal-close fechar-modal-excluir" type="button" aria-label="Fechar modal">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="modal-subject">
            <div class="modal-header">
                <p class="modal-title">Deseja mesmo <span>excluir</span> essa receita?</p>
            </div>
            <div class="modal-form">
                <form action="#">
                    <div class="sim-btn">
                        <button type="button" id="confirmar-exclusao">Sim</button>
                    </div>
                    <div class="nao-btn">
                        <button type="button" id="cancelar-exclusao">Não</button>
                    </div>
                </form>
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

    const botaoAbrirModalExcluir = document.querySelector(".abrir-modal-excluir");
    botaoAbrirModalExcluir.addEventListener("click", (e) => {
        e.preventDefault();
        const inputs = document.querySelectorAll(".input-receitas input, .input-receitas select");
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
                input.setAttribute("title", "Este campo é obrigatório");
            } else {
                input.style.borderColor = "";
                input.removeAttribute("title");
            }
        });

        if (isFormValid) {
            alert("Cadastro realizado com sucesso!");
            // form.submit(); // Descomente se quiser enviar o formulário de fato
        } else {
            alert("Por favor, preencha todos os campos antes de cadastrar.");
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".input-receitas form");
    
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const inputs = form.querySelectorAll("input");
        let isFormValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isFormValid = false;
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "";
            }
        });

        if (!isFormValid) {
            exibirMensagem("Por favor, preencha todos os campos antes de cadastrar.", "erro");
            return;
        }

        const formData = new FormData(form);

        fetch('../src/despesas/cadastrar-despesa-variados.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                exibirMensagem(result.message, "sucesso");
                form.reset(); 
            } else {
                exibirMensagem('Erro: ' + result.message, "erro");
            }
        })
        .catch(error => {
            exibirMensagem('Erro na requisição: ' + error, "erro");
        });
    });

    function exibirMensagem(mensagem, tipo) {
        let msg = document.createElement('div');
        msg.textContent = mensagem;
        msg.style.position = 'fixed';
        msg.style.top = '20px';
        msg.style.right = '20px';
        msg.style.padding = '10px 20px';
        msg.style.borderRadius = '5px';
        msg.style.color = '#fff';
        msg.style.fontSize = '14px';
        msg.style.zIndex = 9999;
        msg.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
        msg.style.opacity = '0.9';

        if (tipo === 'sucesso') {
            msg.style.backgroundColor = 'green';
        } else {
            msg.style.backgroundColor = 'red';
        }

        document.body.appendChild(msg);

        setTimeout(() => {
            msg.remove();
        }, 3000);
    }
});
</script>

    <script src="../assets/js/inatividade.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

</body>
</html>
