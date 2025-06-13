<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

$queryCat = $conn->query("SELECT id_categoria, nome_categoria FROM categoria_receita");
$categorias = $queryCat->fetchAll(PDO::FETCH_ASSOC);

$queryProd = $conn->query("SELECT id_produto, nome_produto FROM produtos");
$produtos = $queryProd->fetchAll(PDO::FETCH_ASSOC);

$sabores = $conn->query("SELECT id_sabor, nome_sabor FROM SABOR_PRODUTO")->fetchAll(PDO::FETCH_ASSOC);

$queryPag = $conn->query("SELECT id_forma_pagamento, descricao FROM formas_pagamento");
$formas_pagamento = $queryPag->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/cadastrar_receitas.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../assets/css/modal_excluir_receita.css">
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

    <main class="main-container">
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

        <div class="input-receitas">
            <form action="../src/receitas/salvar-receita.php" method="post" id="form-receita">
                <div class="form-title" >
                    <h2>Cadastrar Receitas</h2>
                     <a href="../public/receitas_kibon.php"><button type="button" class="ver-receitas">Ver receitas</button></a>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="data-venda">Data da venda</label>
                        <input type="date" id="data-venda" name="data-venda" required>
                    </div>

                    <div class="input-box">
                        <label for="nome-cliente">Nome do Cliente</label>
                        <input type="text" id="nome-cliente" name="nome-cliente" required>
                    </div>

                    <div class="input-box">
                        <label for="nome-produto">Produto</label>
                        <select id="nome-produto" name="nome-produto" required>
                            <option value="">Selecione</option>
                            <?php foreach ($produtos as $prod): ?>
                                <option value="<?= $prod['id_produto'] ?>">
                                    <?= htmlspecialchars($prod['nome_produto']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="sabor-produto">Sabor</label>
                        <select id="sabor-produto" name="sabor-produto" required>
                            <option value="">Selecione</option>
                            <?php foreach ($sabores as $sabor): ?>
                                <option value="<?= $sabor['id_sabor'] ?>"><?= htmlspecialchars($sabor['nome_sabor']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="valor-unitario">Valor Unitário</label>
                        <input type="number" id="valor-unitario" name="valor-unitario" step="0.01" required>
                    </div>

                    <div class="input-box">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nome_categoria']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>

                    <div class="input-box">
                        <label for="pagamento">Forma de Pagamento</label>
                        <select id="pagamento" name="pagamento" required>
                            <option value="">Selecione</option>
                            <?php foreach ($formas_pagamento as $fp): ?>
                                <option value="<?= $fp['id_forma_pagamento'] ?>">
                                    <?= htmlspecialchars($fp['descricao']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade</label>
                        <input type="number" id="quantidade" name="quantidade" required>
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

        <div id="success-popup" 
     style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); z-index: 1000; 
            opacity: 0; 
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;">
  Receita salva com sucesso!
</div>

    </main>

    <div class="modal-overlay hidden" id="modal-excluir-receita">

        <div class="modal-box">
    
            <button class="modal-close fechar-modal-excluir" type="button">
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
                    <form action="#">
                        <div class="sim-btn">
                            <a href="../public/login.html"><button type="button">Sim</button></a>
                        </div>
                        <div class="nao-btn">
                            <button type="button" class="close-modal">Não</button>
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
                const modalExcluirReceita = document.getElementById("modal-excluir-receita");
                modalExcluirReceita.classList.remove("hidden");
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
            } else {
                alert("Por favor, preencha todos os campos antes de cadastrar.");
            }
        });

        document.getElementById("quantidade").addEventListener("input", calculateTotal);
        document.getElementById("valor-unitario").addEventListener("input", calculateTotal);

        function calculateTotal() {
            const quantidade = parseFloat(document.getElementById("quantidade").value) || 0;
            const valorUnitario = parseFloat(document.getElementById("valor-unitario").value) || 0;
            const total = quantidade * valorUnitario;

            const totalInput = document.getElementById("total");
            totalInput.value = total.toLocaleString("pt-BR", {
                style: "currency",
                currency: "BRL"
            });
        }
    </script>

<script>
    document.getElementById('form-receita').addEventListener('submit', async function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: formData
            });

            if (response.ok) {
                showSuccessPopup();
                form.reset();
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao enviar os dados!');
        }
    });

    function showSuccessPopup() {
        const popup = document.getElementById('success-popup');
        popup.style.display = 'block';
        void popup.offsetWidth;
        popup.style.opacity = '1';
        popup.style.transform = 'translateY(0)';

        setTimeout(() => {
            popup.style.opacity = '0';
            popup.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                popup.style.display = 'none';
            }, 500);
        }, 5000);
    }
</script>

<script>
document.getElementById('form-receita').addEventListener('submit', function(event) {
    const valorUnitario = parseFloat(document.getElementById('valor-unitario').value);
    const quantidade = parseInt(document.getElementById('quantidade').value);

    if (valorUnitario < 0 || quantidade < 0) {
        event.preventDefault();
        showToast('Os valores de "Valor Unitário" e "Quantidade" não podem ser negativos!');
    }
});

function showToast(message) {
    const toast = document.createElement('div');
    toast.innerText = message;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = '#e74c3c';
    toast.style.color = '#fff';
    toast.style.padding = '15px 20px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(20px)';
    toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    toast.style.zIndex = '9999';
    toast.style.fontFamily = 'Arial, sans-serif';

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 100);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 500);
    }, 5000); 
}
</script>

<script src="../assets/js/inatividade.js"></script>

</body>
</html>

