<?php include '../src/login/verify-session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/modalrecover.css">
    <link rel="stylesheet" href="../assets/css/redefinir_senha.css">
     <!-- LINKS DO "X" PRA FECHAR O MODAL E DA FOLHA DE ESTILO DO MODAL -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="../assets/css/modal_redefinir_senha.css">
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
                                <li><a href="cadastrar_funcionario.html">Funcionário</a></li>
                                <li><a href="receitas_kibon.html">Receitas</a></li>
                                <li><a href="cadastrar_receitas.html">Cadastro de Receitas</a></li>
                                <li><a href="despesas_fixas.html">Despesas</a></li>
                                <li><a href="cadastrar_despesas_fixas.html">Cadastro de Despesas</a></li>
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
    
        <!-- Formulário de Redefinição de Senha -->
        <main class="form-wrapper">

            <div class="form-container">

              <h2>Redefinição de senha</h2>

              <form id="form-redefinir-senha" action="../src/profile/reset-password.php" method="POST">
                <div class="form-box">
                    <div class="form-group">
                        <label for="senha-antiga">Senha anterior</label>
                        <input type="password" id="senha-antiga" name="senha_antiga" placeholder="Digite a senha anterior" required>
                    </div>

                    <div class="form-group">
                        <label for="nova-senha">Nova senha</label>
                        <input type="password" id="nova-senha" name="nova_senha" placeholder="Crie uma senha" required>
                        <small id="forca-senha" class="senha-status"></small>
                    </div>

                    <div class="form-group">
                        <label for="repetir-senha">Repetir senha</label>
                        <input type="password" id="repetir-senha" name="repetir_senha" placeholder="Repita a senha criada" required>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="button" class="open-modal2" data-modal-2="meuModal2">Salvar</button>
                    <a href="../public/profile.php" class="btn-voltar">Voltar</a>
                </div>

              </form>

            </div>

        </main>

    </div>

    <!-- Modal Confirmação de Redefinição de Senha - Botão "Salvar" -->

    <!-- Modal -->
    <div class="modal-overlay hidden" id="modal-1">

        <div class="modal-box">

            <button class="modal-close close-modal" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-subject">
                <div class="modal-header">
                    <p class="modal-title">Deseja mesmo <span>sair</span> da sua conta?</p>
                </div>

                <div class="modal-form">
                    <form action="../src/login/logout.php" method="post">
                            <div class="sim-btn">
                                <button type="submit">Sim</button>
                            </div>

                        <div class="nao-btn">
                            <a href="redefinir_senha.html"><button type="button">Não</button></a>
                        </div>

                    </form>

                </div>

            </div>
            
        </div>
        
    </div>
    
    <!-- Modal de redefinição de senha -->
    <div id="meuModal2" class="modal2-overlay hidden">
        <div class="modal2-box">
            <button class="modal2-close close-modal2" type="button">&times;</button>
            <p class="modal-title">Deseja mesmo <span>redefinir</span> sua senha?</p>
            <div class="modal2-form">
                <div class="modal2-btn-sim">
                    <button type="button" id="confirmar-redefinicao">Sim</button>
                </div>
                <div class="modal2-btn-nao">
                    <button type="button" class="close-modal2">Não</button>
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
    
    <script>
        // Função para validar a senha conforme os requisitos
        function validarSenhaForte(senha) {
            // Pelo menos 8 caracteres, uma maiúscula, uma minúscula, um número e um caractere especial
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/.test(senha);
        }

        document.querySelectorAll(".open-modal2").forEach(button => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                const novaSenha = document.getElementById("nova-senha").value.trim();
                const repetirSenha = document.getElementById("repetir-senha").value.trim();

                if (novaSenha && repetirSenha) {
                    if (!validarSenhaForte(novaSenha)) {
                        alert("A nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
                    } else if (novaSenha !== repetirSenha) {
                        alert("As senhas não coincidem. Por favor, tente novamente.");
                    } else {
                        const modalId = button.getAttribute("data-modal-2");
                        document.getElementById(modalId).classList.remove("hidden");
                    }
                } else {
                    alert("Por favor, preencha todos os campos.");
                }
            });
        });

        document.getElementById("confirmar-redefinicao").addEventListener("click", () => {
            const novaSenha = document.getElementById("nova-senha").value.trim();
            const repetirSenha = document.getElementById("repetir-senha").value.trim();
            if (!validarSenhaForte(novaSenha)) {
                alert("A nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
                return;
            }
            if (novaSenha !== repetirSenha) {
                alert("As senhas não coincidem. Por favor, tente novamente.");
                return;
            }
            const form = document.querySelector("main .form-container form");
            if (form) {
                form.submit();
            } else {
                alert("Formulário não encontrado.");
            }
        });

    </script>
      <script>
            document.getElementById("nova-senha").addEventListener("input", function () {
                const senha = this.value;
                const statusEl = document.getElementById("forca-senha");

                // Remove classes anteriores
                statusEl.classList.remove("senha-fraca", "senha-media", "senha-forte");

                let forca = 0;

                if (senha.length >= 8) forca++;
                if (/[a-z]/.test(senha)) forca++;
                if (/[A-Z]/.test(senha)) forca++;
                if (/\d/.test(senha)) forca++;
                if (/[^A-Za-z0-9]/.test(senha)) forca++;

                if (senha.length === 0) {
                    statusEl.textContent = "";
                    return;
                }

                if (forca <= 2) {
                    statusEl.textContent = "Senha fraca";
                    statusEl.classList.add("senha-fraca");
                } else if (forca === 3 || forca === 4) {
                    statusEl.textContent = "Senha média";
                    statusEl.classList.add("senha-media");
                } else {
                    statusEl.textContent = "Senha forte";
                    statusEl.classList.add("senha-forte");
                }
            });
     </script>
     <script src="../assets/js/inatividade.js"></script>
</body>
<?php if (isset($_GET['senha']) && $_GET['senha'] === 'ok'): ?>
    <div class="alert-success">
        Senha redefinida com sucesso!
    </div>
<?php endif; ?>
</html>