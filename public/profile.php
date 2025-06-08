<?php 
include '../src/login/verify-session.php'; 
include __DIR__ . '/../config/config.php';

$user_id = $_SESSION['id_usuario'] ?? null;

if (!$user_id) {
    header('Location: login.html');
    exit;
}

$conn = Conexao::getConn();

$sql = "SELECT u.nome_usuario, u.cpf_usuario, u.cnpj_usuario, u.email_usuario, u.tipo_usuario, e.cep, e.rua, e.bairro, e.cidade, e.estado, t.num_telefone, t.ddd, c.nome_cargo, c.nivel_permissao
FROM USUARIO u
LEFT JOIN ENDERECO e ON u.id_usuario = e.id_usuario
LEFT JOIN TELEFONE t ON u.id_usuario = t.id_usuario
LEFT JOIN CARGO c ON u.id_cargo = c.id_cargo
WHERE u.id_usuario = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuário não encontrado.");
}

$nomeCargo = $usuario['nome_cargo'] ?? 'Sem cargo';
$nivelPermissao = $usuario['nivel_permissao'] ?? 0;

$sqlCargos = "SELECT id_cargo AS id, nome_cargo AS nome, nivel_permissao FROM CARGO";
$stmtCargos = $conn->prepare($sqlCargos);
$stmtCargos->execute();
$cargos = $stmtCargos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/profile.css">
  <link rel="stylesheet" href="../assets/css/toast.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../assets/css/modalsair.css">
  <link rel="stylesheet" href="../assets/css/modalcadastro.css">
  <link rel="stylesheet" href="../assets/css/modaldesativar.css">
</head>

<script>
    document.getElementById('confirmarDesativacao').addEventListener('click', function () {
    fetch('desativar_conta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.href = 'login.html'; 
        }
    })
    .catch(error => {
        alert('Erro ao tentar desativar a conta.');
        console.error(error);
    });
});
</script>

<body>
    <script>
        // Alerta de sucesso na redefinição de senha
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'senha_alterada'): ?>
            window.addEventListener('DOMContentLoaded', function() {
                alert('Senha redefinida com sucesso!');
            });
        <?php endif; ?>
    </script>
   
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
              <img src="../assets/img/profileicon.svg" alt="Ícone Perfil">
              <h3>Editar meu perfil</h3>
            </div>
             <button class="add-user-btn"><a href="redefinir_senha.php">Alterar senha</a></button>
          </div>
          <main class="main">
            <form id="form-dados" class="form-grid" method="post" action="../src/profile/save-profile.php">
              <input id="nome" name="nome" type="text" placeholder="*Nome" required value="<?= htmlspecialchars($usuario['nome_usuario'] ?? '') ?>">
              <input id="cidade" name="cidade" type="text" placeholder="Cidade" value="<?= htmlspecialchars($usuario['cidade'] ?? '') ?>">
              <input id="cpf" name="cpf" type="text" placeholder="CPF" value="<?= htmlspecialchars((strtolower(trim($usuario['tipo_usuario'] ?? '')) === 'admin' && !empty($usuario['cnpj_usuario'])) ? $usuario['cnpj_usuario'] : ($usuario['cpf_usuario'] ?? '')) ?>">
              <input id="estado" name="estado" type="text" placeholder="Estado" value="<?= htmlspecialchars($usuario['estado'] ?? '') ?>">
              <input id="cep" name="cep" type="text" placeholder="CEP" value="<?= htmlspecialchars($usuario['cep'] ?? '') ?>">
              <input name="telefone" type="text" placeholder="Telefone" inputmode="numeric"  title="Por favor, insira apenas números." pattern="\d*" value="<?= htmlspecialchars($usuario['num_telefone'] ?? '') ?>">
              <input id="rua" name="rua" type="text" placeholder="Rua" value="<?= htmlspecialchars($usuario['rua'] ?? '') ?>">
              <input name="ddd" type="text" placeholder="DDD" inputmode="numeric" title="Por favor, insira apenas números." pattern="\d*" value="<?= htmlspecialchars($usuario['ddd'] ?? '') ?>">
              <input id="bairro" name="bairro" type="text" placeholder="Bairro" value="<?= htmlspecialchars($usuario['bairro'] ?? '') ?>">
              <input name="email" type="email" placeholder="Email" value="<?= htmlspecialchars($usuario['email_usuario'] ?? '') ?>">
              <button type="submit" class="btn">Salvar</button>
            </form>

            <div id="mensagem"></div>

          </main>

          <?php 
            if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): 
                $sql = "SELECT id_usuario, nome_usuario, email_usuario, data_adicao 
                        FROM USUARIO 
                        WHERE ativo = 1";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
                <div class="header-card">
                    <div class="left-content">
                        <img src="../assets/img/profileicon.svg" alt="Ícone usuário" />
                        <span>Adicionar usuário</span>
                    </div>
                    <button class="open-modal" data-modal="modal-cadastro">Adicionar novo usuário</button>
                </div>
            <?php endif; ?>

<div class="card">
    <?php if (count($usuarios) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($usuario['data_adicao'])); ?></td>
                        <td><?= htmlspecialchars($usuario['nome_usuario']); ?></td>
                        <td><?= htmlspecialchars($usuario['email_usuario']); ?></td>
                        <td class="actions">
                            <button class="btn-edit" data-id="<?= $usuario['id_usuario']; ?>">Editar</button>
                            <button class="btn-desativar-conta js-open-modal-desativar" data-modal="modal-1" data-id="<?= $usuario['id_usuario']; ?>">Desativar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum usuário cadastrado.</p>
    <?php endif; ?>
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
              <p class="modal-title">Cadastre um novo usuário</p>
          </div>

          <div class="modal-form-new-user">
              <form>
                  <div class="input-group">
                      <div class="input-box">
                          <label for="cadastro-nome">Nome</label>
                          <input type="text" id="cadastro-nome" name="nome" placeholder="Digite o nome do novo usuário" required>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-sobrenome">Sobrenome</label>
                          <input type="text" id="cadastro-sobrenome" name="sobrenome" placeholder="Digite o sobrenome do novo usuário" required>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-cpf">CPF</label>
                          <input type="text" id="cadastro-cpf" name="cpf" placeholder="Digite o CPF do novo usuário" required>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-email">E-mail</label>
                          <input type="email" id="cadastro-email" name="email" placeholder="Digite o e-mail do novo usuário" required>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-cargo">Cargo</label>
                          <select id="cadastro-cargo" name="cargo" required>
                              <option value="">Selecione o cargo</option>
                              <?php foreach ($cargos as $cargo): ?>
                                  <option 
                                    value="<?= htmlspecialchars($cargo['id']) ?>" 
                                    data-nivel="<?= htmlspecialchars($cargo['nivel_permissao']) ?>">
                                      <?= htmlspecialchars($cargo['nome']) ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-nivel">Nível de permissão</label>
                          <input type="text" id="cadastro-nivel" name="nivel" readonly placeholder="Selecione um cargo">
                      </div>

                      <div class="input-box">
                          <label for="cadastro-senha">Senha</label>
                          <input type="password" id="cadastro-senha" name="senha" placeholder="Crie uma senha" required>
                      </div>

                      <div class="input-box">
                          <label for="cadastro-repetir-senha">Repetir senha</label>
                          <input type="password" id="cadastro-repetir-senha" name="repetir_senha" placeholder="Repita a senha criada" required>
                      </div>
                  </div>

                  <div class="criar-btn">
                      <button type="submit">Criar Conta</button>
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
              <p class="modal-title-desativar">Deseja mesmo <span>desativar</span> a conta deste usuário?</p>
          </div>

          <div class="modal-form-desativar">
              <form action="#">
                  <div class="sim-btn-desativar">
                     <button type="button" id="confirmarDesativacao">Sim</button>
                  </div>
                  <div class="nao-btn-desativar">
                      <button type="button">Não</button>
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
        document.getElementById("cadastro-cargo").addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        const nivel = selectedOption.getAttribute("data-nivel") || "";
        document.getElementById("cadastro-nivel").value = nivel;
        });
</script>

    <script src="../assets/js/cep-enter-prevent.js"></script>
    <script src="../assets/js/cep.js"></script>
    <script src="../assets/js/user-update.js"></script>
    <script src="../assets/js/user-insert.js"></script>
    <script src="../assets/js/modal-close.js"></script>
    <script src="../assets/js/form-handler.js"></script>
    <script src="../assets/js/update-username.js"></script>
    <script src="../assets/js/user-deactivate.js"></script>

</body>
</html>