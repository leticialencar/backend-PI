<?php
include '../src/login/verify-session.php';
require __DIR__ . '/../config/config.php';

$conn = Conexao::getConn();

try {
    $stmt = $conn->query("SELECT id_cargo, nome_cargo FROM CARGO");
    $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar cargos: " . $e->getMessage();
    exit;
}

try {
    $stmt = $conn->query("
        SELECT f.id_funcionario, f.nome_funcionario, c.nome_cargo
        FROM FUNCIONARIO f
        JOIN CARGO c ON f.id_cargo = c.id_cargo
        ORDER BY f.nome_funcionario ASC
    ");
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar funcionários: " . $e->getMessage();
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
                                <li><a href="../public/cadastrar_funcionario.php">Funcionário</a></li>
                                <li><a href="../public/receitas_kibon.php">Receitas</a></li>
                                <li><a href="../public/cadastrar_receitas.php">Cadastro de Receitas</a></li>
                                <li><a href="../public/despesas_fixas.html">Despesas</a></li>
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

        
        <div class="perfil-header">
            <div class="perfil-title">
                <img src="../assets/img/profilewhite.svg" alt="Ícone Perfil">
                <h3>Cadastrar funcionário</h3>
            </div>
        </div>


        <main class="main">
            <div id="msg-erro" style="color: red; margin-bottom: 10px;"></div>
            <form id="form-dados" class="form-grid" method="POST" action="../src/funcionario/salvar-funcionario.php">
                <input name="nome" type="text" placeholder="*Nome" required>
                <input id="rg" name="rg" type="text" placeholder="RG" pattern="\d+" title="Por favor, insira apenas números" required>
                <input name="cpf" type="number" placeholder="CPF" required>
                <input name="endereço" type="text" placeholder="Endereço" required>
                <input name="cep" type="number" placeholder="CEP" required>
                <input name="numero" type="number" placeholder="Número" required>
                <input name="rua" type="text" placeholder="Cidade" required>
                <input name="bairro" type="text" placeholder="Bairro" required>
                <select  id="cargo" name="cargo" required>
                    <option value="cargo">Cargo</option>
                    <?php foreach ($cargos as $cargo): ?>
                    <option value="<?= htmlspecialchars($cargo['id_cargo']) ?>">
                        <?= htmlspecialchars($cargo['nome_cargo']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <input name="data_admissao" type="date" placeholder="Data de admissão" required>
                 <input name="ddd" type="text" placeholder="Contato" required>
                 <input id="salario" name="salario" type="number" placeholder="Salário" min="0" step="0.01" required />
                <button type="submit" class="btn">Salvar</button>
            </form>
        </main>
        <div class="header-card">
            <div class="left-content">
                <img src="../assets/img/profileadiction.svg" alt="Ícone usuário" />
                <span>Editar informações do funcionário</span>
            </div>
        </div> 

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
                    <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td>
                            <a href="folha_de_pagamento.php?id=<?= $funcionario['id_funcionario'] ?>">
                                <?= htmlspecialchars($funcionario['nome_funcionario']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($funcionario['nome_cargo']) ?></td>
                        <td class="actions">
                            <button class="open-modal" data-id="<?= $funcionario['id_funcionario'] ?>" data-modal="modal-cadastro">Editar</button>
                            <button class="btn-desativar-conta js-open-modal-desativar" data-id="<?= $funcionario['id_funcionario'] ?>" data-modal="modal-1">Desativar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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

        <!-- Modal de Atualização -->
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
                <form action="../src/funcionario/editar-funcionario.php" method="POST">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="Digite o nome" required>
                        </div>

                        <div class="input-box">
                            <label for="rg">RG</label>
                            <input type="text" id="rg" name="rg" placeholder="Digite o RG" required>
                        </div>

                        <div class="input-box">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>
                        </div>

                        <div class="input-box">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço" required>
                        </div>

                        <div class="input-box">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required>
                        </div>

                        <div class="input-box">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" placeholder="Digite o número" required>
                        </div>

                        <div class="input-box">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade" required>
                        </div>

                        <div class="input-box">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" placeholder="Digite o bairro" required>
                        </div>

                        <div class="input-box">
                            <label for="data_admissao">Data de Admissão</label>
                            <input type="date" id="data_admissao" name="data_admissao" required>
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
                            <label for="contato">Contato</label>
                            <input type="text" id="contato" name="contato" placeholder="Digite o número do celular" required>
                        </div>

                        <div class="input-box">
                            <label for="salario">Salário</label>
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