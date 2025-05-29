<?php
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

try {
    $stmt = $conn->query("SELECT id_cargo, nome_cargo FROM CARGO");
    $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar cargos: " . $e->getMessage();
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
    <link rel="stylesheet" href="../assets/css/cadastrar_funcionario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/modalsair.css">
    <link rel="stylesheet" href="../assets/css/modalcadastro.css">
    <link rel="stylesheet" href="../assets/css/modaldesativar.css">
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
                    <li class="active">
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
                                <li><a href="../public/cadastrar_funcionario.html">Funcionário</a></li>
                                <li><a href="../public/receitas_kibon.html">Receitas</a></li>
                                <li><a href="../public/cadastrar_receitas.php">Cadastro de Receitas</a></li>
                                <li><a href="despesas_fixas.html">Despesas</a></li>
                                <li><a href="cadastrar_despesas_fixas.html">Cadastro de Despesas</a></li>
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

        
        <div class="perfil-header">
            <div class="perfil-title">
                <img src="../assets/img/profilewhite.svg" alt="Ícone Perfil">
                <h3>Cadastrar funcionário</h3>
            </div>
        </div>
        <main class="main">
            <form id="form-dados" class="form-grid">
                <input name="nome" type="text" placeholder="*Nome" required>
                <input name="cidade" type="text" placeholder="RG">
                <input name="cpf" type="text" placeholder="CPF">
                <input name="estado" type="text" placeholder="Endereço">
                <input name="cep" type="text" placeholder="CEP">
                <input name="telefone" type="text" placeholder="Número">
                <input name="rua" type="text" placeholder="Cidade">
                <input name="ddd" type="text" placeholder="Bairro">
                <select  id="cargo" name="cargo">
                    <option value="cargo">Cargo</option>
                    <?php foreach ($cargos as $cargo): ?>
                    <option value="<?= htmlspecialchars($cargo['id_cargo']) ?>">
                        <?= htmlspecialchars($cargo['nome_cargo']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <input name="data" type="email" placeholder="Data de admissão">
                 <input name="ddd" type="text" placeholder="Contato">
                  <input name="ddd" type="text" placeholder="Salário">
                <button type="submit" class="btn">Salvar</button>
                <!-- ...existing code... -->
            </form>
        </main>
        <div class="header-card">
            <div class="left-content">
                <img src="../assets/img/profileadiction.svg" alt="Ícone usuário" />
                <span>Editar informações do funcionário</span>
            </div> <!-- FECHA left-content -->
        </div> <!-- FECHA header-card -->

         

        <div class="card">

            <div class="nav-filter-category">
                <div class="filters">
        

                    <select id="produto-filter" name="produto">
                        <option value="produto">Nome </option>
                        <option value="produto1"></option>
                        <option value="produto2"></option>
                        <option value="produto3"></option>
                    </select>

                    <select id="categoria-filter" name="categoria">
                        <option value="categoria">Função</option>
                        <option value="categoria1"></option>
                        <option value="categoria2"></option>
                        <option value="categoria3"></option>
                    </select>
                </div>
            </div>

            <div class="reajuste-salarial">
                <label for="percentualReajuste">Reajuste Salarial (%):</label>
                <input type="number" id="percentualReajuste" step="0.01" placeholder="Ex: 5">
                <button id="aplicarReajuste">Aplicar Reajuste</button>
            </div>

            <table>
              
                <tbody>
                    <tr>
                      
                        <td>Brenda Evelyn da Silva Vieira</td>
                        <td>Caixa</td>
                        <td class="actions">
                            <button class="open-modal" data-modal="modal-cadastro">Editar</button>
                            <button class="btn-desativar-conta js-open-modal-desativar"
                                data-modal="modal-1">Desativar</button>
                        </td>
                    </tr>
                    <tr>
                       
                        <td>Ramon Pietro Felizado Neymar Junior</td>
                        <td>Vendedor</td>
                        <td class="actions">
                            <button class="open-modal" data-modal="modal-cadastro">Editar</button>
                            <button class="btn-desativar-conta js-open-modal-desativar"
                                data-modal="modal-1">Desativar</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>


        
            
    </div>


        <!-- Modal de Sair -->
        <div class="modal-overlay hidden" id="modal-sair">
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
                                <a href="/html/login.html"><button type="button">Sim</button></a>
                            </div>
                            <div class="nao-btn">
                                <button type="button" class="close-modal">Não</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cadastro -->
        <div class="modal-overlay hidden" id="modal-cadastro">
            <div class="modal-box">
                <button class="modal-close close-modal close-modal-cadastro" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="modal-subject">
                    <div class="modal-header">
                        <p class="modal-title">Editar cadastro do funcionário</p>
                    </div>

                    <div class="modal-form-new-user">
    <form action="#">
        <div class="input-group">
            <div class="input-box">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome " required>
            </div>


            <div class="input-box">
                <label for="cpf">RG</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o RG" required>
            </div>

            <div class="input-box">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>
            </div>

            <div class="input-box">
                <label for="Endereço">Endereço</label>
                <input type="Endereço" id="Endereço" name="Endereço" placeholder="Digite o endereço" required>
            </div>

            <div class="input-box">
                <label for="sobrenome">CEP</label>
                <input type="cep" id="cep" name="sobrenome" placeholder="Digite o CEP " required>
            </div>

            <div class="input-box">
                <label for="numero">Número</label>
                <input type="Número" id="Número" name="Número" placeholder="Digite o número" required>
            </div>

            <div class="input-box">
                <label for="cidade">Cidade</label>
                <input type="cidade" id="cidade" name="cidade" placeholder="Digite a cidade" required>
            </div>

            <div class="input-box">
                <label for="bairro">Bairro</label>
                <input type="bairro" id="bairro" name="bairro" placeholder="Digite o bairro" required>
            </div>

            <div class="input-box">
                <label for="cargo">Cargo</label>
                <select id="cargo" name="cargo" required>
                    <option value="">Selecione o cargo</option>
                    <option value="admin">Administrador</option>
                    <option value="gerente">Gerente</option>
                    <option value="analista">Analista</option>
                </select>
            </div>

             <div class="input-box">
                <label for="bairro">Data de admissão</label>
                <input type="date" id="data" name="data" required>
            </div>

            <div class="input-box">
                <label for="bairro">Contato</label>
                <input type="contato" id="contato" name="contato" placeholder="Digite o número do celular" required>
            </div>


            <div class="input-box">
                <label for="nivel">Salário</label>
                <input type="text" id="salario" name="salario" placeholder="Digite o salário" required>
            </div>
        </div>
        <div class="criar-btn">
            <button type="submit">Salvar edições</button>
        </div>
    </form>
</div>
                </div>
            </div>
        </div>

        <!-- Modal Desativar Conta -->
        <div class="modal-overlay-desativar hidden" id="modal-1">
            <div class="modal-box-desativar">
                <button class="modal-close-desativar js-close-modal-desativar" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="modal-subject-desativar">
                    <div class="modal-header-desativar">
                        <p class="modal-title-desativar">Deseja mesmo <span>desativar</span> este funcionário?</p>
                    </div>

                    <div class="modal-form-desativar">
                        <form action="#">
                            <div class="sim-btn-desativar">
                                <button type="button">Sim</button>
                            </div>
                            <div class="nao-btn-desativar">
                                <button type="button">Não</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            document.querySelectorAll(".open-modal").forEach(button => {
                button.addEventListener("click", () => {
                    const modalId = button.getAttribute("data-modal");
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove("hidden");
                    }
                });
            });

            // Fecha o modal ao clicar em qualquer botão com a classe modal-close ou na classe nao-btn
            document.querySelectorAll(".close-modal, .nao-btn button").forEach(button => {
                button.addEventListener("click", (e) => {
                    e.preventDefault(); // Evita o comportamento padrão do botão
                    const modal = e.target.closest(".modal-overlay");
                    if (modal) {
                        modal.classList.add("hidden");
                    }
                });
            });

            // Fecha o modal ao clicar fora da caixa do modal
            window.addEventListener("click", (e) => {
                if (e.target.classList.contains("modal-overlay")) {
                    e.target.classList.add("hidden");
                }
            });
        </script>
        <script>
            document.getElementById('form-dados').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());

                const response = await fetch('/api/salvar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    alert('Dados salvos com sucesso!');
                } else {
                    alert('Erro ao salvar os dados.');
                }
            });
            // Script para o botão de editar

        </script>

        <script>
            // Script seguro para modal de desativar conta
            const openModalDesativarBtns = document.querySelectorAll(".js-open-modal-desativar");
            const modalDesativar = document.getElementById("modal-1");
            const closeModalDesativarBtn = modalDesativar.querySelector(".js-close-modal-desativar");
            const naoBtnDesativar = modalDesativar.querySelector(".nao-btn-desativar button");
            const simBtnDesativar = modalDesativar.querySelector(".sim-btn-desativar button");

            let currentRow; // Variável para armazenar a linha atual

            openModalDesativarBtns.forEach(button => {
                button.addEventListener("click", (e) => {
                    currentRow = e.target.closest("tr"); // Armazena a linha da tabela associada ao botão
                    modalDesativar.classList.remove("hidden");
                });
            });

            closeModalDesativarBtn.addEventListener("click", () => {
                modalDesativar.classList.add("hidden");
            });

            naoBtnDesativar.addEventListener("click", () => {
                modalDesativar.classList.add("hidden");
            });

            simBtnDesativar.addEventListener("click", () => {
                if (currentRow) {
                    currentRow.remove(); // Remove a linha da tabela
                    alert("Conta desativada com sucesso!");
                }
                modalDesativar.classList.add("hidden");
            });

            window.addEventListener("click", (e) => {
                if (e.target === modalDesativar) {
                    modalDesativar.classList.add("hidden");
                }
            });
        </script>
        <script>
            // Script para cadastrar novo usuário
            const formCadastro = document.querySelector("#modal-cadastro .modal-form-new-user form");
            const tabelaUsuarios = document.querySelector(".card table tbody");

            formCadastro.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(formCadastro);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('/api/usuarios', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        const novoUsuario = await response.json();

                        const novaLinha = document.createElement("tr");
                        novaLinha.innerHTML = `
          <td>${new Date().toLocaleDateString()}</td>
          <td>${novoUsuario.nome} ${novoUsuario.sobrenome}</td>
          <td>${novoUsuario.email}</td>
          <td class="actions">
            <button class="btn-edit">Editar</button>
            <button class="btn-desativar-conta js-open-modal-desativar" data-modal="modal-1">Desativar</button>
          </td>
        `;
                        tabelaUsuarios.appendChild(novaLinha);

                        // Reatribui eventos aos botões "Desativar" para novos usuários
                        novaLinha.querySelector(".js-open-modal-desativar").addEventListener("click", (e) => {
                            currentRow = e.target.closest("tr");
                            modalDesativar.classList.remove("hidden");
                        });

                        // Fecha o modal de cadastro
                        document.getElementById("modal-cadastro").classList.add("hidden");

                        // Limpa o formulário
                        formCadastro.reset();

                        alert("Usuário cadastrado com sucesso!");
                    } else {
                        alert("Erro ao cadastrar o usuário.");
                    }
                } catch (error) {
                    console.error("Erro ao cadastrar o usuário:", error);
                    alert("Erro ao cadastrar o usuário.");
                }
            });
        </script>
        <script>
            // Script para abrir o modal de cadastro com informações preenchidas para edição
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", (e) => {
                    const row = e.target.closest("tr");
                    const nomeCompleto = row.children[1].textContent.trim().split(" ");
                    const email = row.children[2].textContent.trim();

                    // Preenche os campos do modal de cadastro
                    document.getElementById("nome").value = nomeCompleto[0];
                    document.getElementById("sobrenome").value = nomeCompleto.slice(1).join(" ");
                    document.getElementById("cpf").value = ""; // Preencha com o CPF se disponível
                    document.getElementById("email").value = email;
                    document.getElementById("cargo").value = ""; // Preencha com o cargo se disponível
                    document.getElementById("nivel").value = ""; // Preencha com o nível de permissão se disponível

                    // Altera o texto do botão para "Alterar Informações"
                    const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
                    submitButton.textContent = "Alterar Informações";

                    // Abre o modal de cadastro
                    document.getElementById("modal-cadastro").classList.remove("hidden");
                });
            });

            // Submissão do formulário de cadastro/edição
            document.querySelector("#modal-cadastro .modal-form-new-user form").addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('/api/usuarios', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        alert("Usuário salvo com sucesso!");
                        location.reload(); // Atualiza a página para refletir as alterações
                    } else {
                        alert("Erro ao salvar o usuário.");
                    }
                } catch (error) {
                    console.error("Erro ao salvar o usuário:", error);
                    alert("Erro de conexão.");
                }

                // Restaura o texto do botão para "Criar Conta"
                const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
                submitButton.textContent = "Criar Conta";

                // Fecha o modal de cadastro
                document.getElementById("modal-cadastro").classList.add("hidden");
            });
        </script>
        <script>
            // Script para abrir o modal de cadastro com formulário limpo
            document.querySelector(".open-modal[data-modal='modal-cadastro']").addEventListener("click", () => {
                // Limpa os campos do formulário
                document.querySelectorAll("#modal-cadastro input").forEach(input => input.value = "");
                document.querySelector("#cargo").value = "";
                document.querySelector("#nivel").value = "";

                // Restaura o texto do botão para "Criar Conta"
                const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
                submitButton.textContent = "Criar Conta";

                // Abre o modal de cadastro
                document.getElementById("modal-cadastro").classList.remove("hidden");
            });

            // Script para abrir o modal de cadastro com informações preenchidas para edição
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", (e) => {
                    const row = e.target.closest("tr");
                    const nomeCompleto = row.children[1].textContent.trim().split(" ");
                    const email = row.children[2].textContent.trim();

                    // Preenche os campos do modal de cadastro
                    document.getElementById("nome").value = nomeCompleto[0];
                    document.getElementById("sobrenome").value = nomeCompleto.slice(1).join(" ");
                    document.getElementById("cpf").value = ""; // Preencha com o CPF se disponível
                    document.getElementById("email").value = email;
                    document.getElementById("cargo").value = ""; // Preencha com o cargo se disponível
                    document.getElementById("nivel").value = ""; // Preencha com o nível de permissão se disponível

                    // Altera o texto do botão para "Alterar Informações"
                    const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
                    submitButton.textContent = "Alterar Informações";

                    // Abre o modal de cadastro
                    document.getElementById("modal-cadastro").classList.remove("hidden");
                });
            });

            // Submissão do formulário de cadastro/edição
            document.querySelector("#modal-cadastro .modal-form-new-user form").addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('/api/usuarios', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        alert("Usuário salvo com sucesso!");
                        location.reload(); // Atualiza a página para refletir as alterações
                    } else {
                        alert("Erro ao salvar o usuário.");
                    }
                } catch (error) {
                    console.error("Erro ao salvar o usuário:", error);
                    alert("Erro de conexão.");
                }

                // Restaura o texto do botão para "Criar Conta"
                const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
                submitButton.textContent = "Criar Conta";

                // Fecha o modal de cadastro
                document.getElementById("modal-cadastro").classList.add("hidden");
            });
        </script>





        <!-- CRIPT REAJUSTE SALARIAL -->
        
        <script>
            document.getElementById('aplicarReajuste').addEventListener('click', async () => {
                const percentual = parseFloat(document.getElementById('percentualReajuste').value);

                if (isNaN(percentual)) {
                    alert('Digite um valor válido para o reajuste.');
                    return;
                }

                const confirmacao = confirm(`Deseja aplicar um reajuste de ${percentual}% a todos os funcionários?`);
                if (!confirmacao) return;

                try {
                    const response = await fetch('/api/reajustar_salarios', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ percentual })
                    });

                    if (response.ok) {
                        alert('Reajuste aplicado com sucesso!');
                        location.reload(); // Recarrega a lista atualizada
                    } else {
                        alert('Erro ao aplicar o reajuste.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Erro inesperado ao aplicar o reajuste.');
                }
            });
        </script>


</body>

</html>