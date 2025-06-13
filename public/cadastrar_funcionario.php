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
    $stmt = $conn->query("SELECT f.id_funcionario, f.nome_funcionario, c.nome_cargo
        FROM FUNCIONARIO f
        JOIN CARGO c ON f.id_cargo = c.id_cargo
        ORDER BY f.nome_funcionario ASC");
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
    <link rel="stylesheet" href="../assets/css/modaldesativar.css">
    <link rel="stylesheet" href="../assets/css/modalcadastro.css">
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

        
        <div class="perfil-header">
            <div class="perfil-title">
                <img src="../assets/img/profilewhite.svg" alt="Ícone Perfil">
                <h3>Cadastrar funcionário</h3>
            </div>
        </div>


        <main class="main">
            <div id="msg-erro" style="color: red; margin-bottom: 10px;"></div>
            <form id="form-dados" class="form-grid" method="POST" action="../src/funcionario/salvar-funcionario.php">
                <input name="nome" type="text" placeholder="Nome" required>
                <!-- <input id="rg" name="rg" type="text" placeholder="RG" pattern="\d+" title="Por favor, insira apenas números" required> -->
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
                 <input id="salario" name="salario" type="number" placeholder="Salário Bruto" min="0" step="0.01" required />
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
                
            <form id="form-pesquisa" class="barra-pesquisa">
                <input type="text" name="busca" id="busca" placeholder="Pesquise por nome ou função do funcionário">
                <button type="submit" class="pesquisar-button">Pesquisar</button>
                </form>

            <div class="reajuste-salarial">
                <label for="percentualReajuste">Reajuste Salarial (%):</label>
                <input type="number" id="percentualReajuste" step="0.01" placeholder="Ex: 5">
                <button id="aplicarReajuste">Aplicar Reajuste</button>
            </div>

            <table>
                <tbody id="resultado-funcionarios">
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
<div class="modal-cadastro-overlay hidden" id="modal-cadastro">
    <div class="modal-cadastro-box">
        <button class="modal-close close-modal-cadastro" type="button">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-subject">
            <div class="modal-header">
                <p class="modal-title">Editar cadastro do funcionário</p>
            </div>

            <div class="modal-form-new-user">
                <form action="../src/funcionario/editar-funcionario.php" method="POST">
                    <!-- Campo oculto para o ID do funcionário -->
                    <input type="hidden" name="id_funcionario" id="id_funcionario">

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
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required>
                        </div>

                        <div class="input-box">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço" required>
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
                            <select  id="cargo" name="cargo" required>
                                <option value="cargo">Cargo</option>
                                <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= htmlspecialchars($cargo['id_cargo']) ?>">
                                    <?= htmlspecialchars($cargo['nome_cargo']) ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" placeholder="Digite o número do celular" maxlength="9" required>
                        </div>

                        <div class="input-box">
                            <label for="salario">Salário Bruto</label>
                            <input type="text" id="salario" name="salario" placeholder="Digite o salário" required>
                        </div>
                    </div>

                    <div class="criar-btn">
                        <button type="submit">Salvar edições</button>
                    </div>
                </form>

                <div id="mensagem-sucesso" style="display:none; color: green; margin-top: 10px;"></div>

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

        <script>
document.addEventListener('DOMContentLoaded', () => {
    const cepInput = document.querySelector('#cep');

    if (cepInput) {
        cepInput.addEventListener('blur', () => {
            const cep = cepInput.value.replace(/\D/g, '');

            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.querySelector('#endereco').value = data.logradouro || '';
                            document.querySelector('#bairro').value = data.bairro || '';
                            document.querySelector('#cidade').value = data.localidade || '';
                        } else {
                            alert("CEP não encontrado.");
                        }
                    })
                    .catch(() => alert("Erro ao buscar o CEP."));
            }
        });
    }
});
</script>

        <script>
document.querySelectorAll('button.open-modal[data-modal="modal-cadastro"]').forEach(btn => {
  btn.addEventListener('click', async e => {
    const id = btn.dataset.id;
    const res = await fetch(`../src/funcionario/get-funcionario.php?id=${id}`);
    const dados = await res.json();
    if (dados.erro) return alert(dados.erro);

    const modal = document.getElementById('modal-cadastro');
    modal.querySelector('input[name="id_funcionario"]').value = dados.id_funcionario;
    modal.querySelector('input[name="nome"]').value = dados.nome_funcionario;
    modal.querySelector('input[name="rg"]').value = dados.rg;
    modal.querySelector('input[name="cpf"]').value = dados.cpf;
    modal.querySelector('input[name="endereco"]').value = dados.rua;
    modal.querySelector('input[name="cep"]').value = dados.cep;
    modal.querySelector('input[name="numero"]').value = dados.numero;
    modal.querySelector('input[name="cidade"]').value = dados.cidade;
    modal.querySelector('input[name="bairro"]').value = dados.bairro;
    modal.querySelector('input[name="data_admissao"]').value = dados.data_admissao;
    modal.querySelector('select[name="cargo"]').value = dados.id_cargo;
    modal.querySelector('input[name="contato"]').value = dados.contato;
    modal.querySelector('input[name="salario"]').value = dados.salario;

    modal.classList.remove('hidden');
  });
});

document.querySelectorAll('.close-modal-cadastro').forEach(btn => {
  btn.addEventListener('click', () => document.getElementById('modal-cadastro').classList.add('hidden'));
});
</script>

 <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cepInput = document.querySelector("input[name='cep']");
                const ruaInput = document.querySelector("input[name='endereço']");
                const bairroInput = document.querySelector("input[name='bairro']");
                const cidadeInput = document.querySelector("input[name='rua']");

                cepInput.addEventListener("blur", function () {
                    const cep = cepInput.value.replace(/\D/g, '');

                    if (cep.length === 8) {
                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                            .then(response => response.json())
                            .then(data => {
                                if (!data.erro) {
                                    ruaInput.value = data.logradouro || '';
                                    bairroInput.value = data.bairro || '';
                                    cidadeInput.value = data.localidade || '';
                                } else {
                                    alert("CEP não encontrado.");
                                }
                            })
                            .catch(() => {
                                alert("Erro ao buscar o CEP.");
                            });
                    }
                });
            });
            </script>

            <script>
            document.getElementById('form-dados').addEventListener('submit', function(e) {
                e.preventDefault(); 

                const form = e.target;
                const formData = new FormData(form);
                const msgErro = document.getElementById('msg-erro');

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        msgErro.style.color = 'green';
                        msgErro.textContent = data.message;
                        form.reset(); 
                    } else {
                        msgErro.style.color = 'red';
                        msgErro.textContent = data.message;
                    }
                })
                .catch(() => {
                    msgErro.style.color = 'red';
                    msgErro.textContent = 'Erro ao comunicar com o servidor.';
                });
            });
            </script>

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

            document.querySelectorAll(".close-modal, .nao-btn button").forEach(button => {
                button.addEventListener("click", (e) => {
                    e.preventDefault(); 
                    const modal = e.target.closest(".modal-overlay");
                    if (modal) {
                        modal.classList.add("hidden");
                    }
                });
            });

            window.addEventListener("click", (e) => {
                if (e.target.classList.contains("modal-overlay")) {
                    e.target.classList.add("hidden");
                }
            });
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
                    currentRow.remove(); 
                    alert("Funcinário desativado com sucesso!");
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
  document.getElementById('aplicarReajuste').addEventListener('click', () => {
    const percentual = parseFloat(document.getElementById('percentualReajuste').value);
    if (isNaN(percentual)) {
      alert('Por favor, digite um percentual válido.');
      return;
    }

    fetch('../src/funcionario/reajustar-salario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ percentual: percentual })
    })
    .then(res => res.json())
    .then(data => {
      if (data.sucesso) {
        alert(data.mensagem);
        location.reload();
      } else {
        alert('Erro: ' + data.mensagem);
      }
    })
    .catch(() => alert('Erro na comunicação com o servidor.'));
  });
</script>

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

    let usuarioParaDesativar = null;

    document.querySelectorAll('.btn-desativar-conta').forEach(btn => {
        btn.addEventListener('click', function() {
            usuarioParaDesativar = this.getAttribute('data-id');
            document.getElementById('modal-1').classList.remove('hidden');
        });
    });

    document.getElementById('confirmarDesativacao').addEventListener('click', function () {
        if (!usuarioParaDesativar) return;
        fetch('desativar_conta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_usuario=' + encodeURIComponent(usuarioParaDesativar)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            alert('conta desativada com sucesso.');
            console.error(error);
        });
    });

    document.querySelectorAll('.nao-btn-desativar button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modal-1').classList.add('hidden');
            usuarioParaDesativar = null;
        });
    });
    </script>

    <script>
document.getElementById('form-pesquisa').addEventListener('submit', function(e) {
  e.preventDefault(); // evita o envio tradicional do formulário
  const busca = document.getElementById('busca').value;

  fetch('../src/funcionario/buscar-funcionario.php?busca=' + encodeURIComponent(busca))
    .then(response => response.text())
    .then(html => {
      document.getElementById('resultado-funcionarios').innerHTML = html;
    })
    .catch(error => {
      console.error('Erro ao buscar funcionários:', error);
    });
});
</script>


    <script src="../assets/js/inatividade.js"></script>

</body>

</html>