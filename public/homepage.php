<?php include '../src/login/verify-session.php'; ?>

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
            <div class="card">
                <div class="card-header">Para Hoje (Receita/Despesas)</div>
                <div class="card-body">
                    <p>✅ Nenhum lançamento para hoje</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Movimentações Atrasadas (Receita/Despesas)</div>
                <div class="card-body">
                    <p>✅ Nenhum lançamento em atraso</p>
                </div>
            </div>
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
                            <a href="login.html"><button type="button">Sim</button></a>
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

    <script src="../assets/js/inatividade.js"></script>

</body>
</html>
