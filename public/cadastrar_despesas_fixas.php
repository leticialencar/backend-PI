<?php
include '../src/login/verify-session.php'; 
require __DIR__ . '/../config/config.php';
$conn = Conexao::getConn();

$sql = "SELECT id_forma_pagamento, descricao FROM formas_pagamento ORDER BY descricao";
$stmt = $conn->prepare($sql);
$stmt->execute();
$formas_pagamento = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>CashHive System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/cadastrar_despesas_fixas.css">
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
        <li class="active"><a href="../public/cadastrar_despesas_fixas.php">Fixos</a></li>
        <li><a href="../public/cadastrar_despesas_produtos.php">Produtos</a></li>
        <li><a href="../public/cadastrar_despesas_variados.php">Variados</li></a>
      </ul>
    </nav>
  </div>

  <main class="main">
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

    <div class="input-receitas">
      <div class="form-title">
        <h2>Cadastrar Despesas</h2>
        <a href="../public/despesas_fixas.php"><button type="button" class="ver-despesas">Ver Despesas</button></a>
      </div>

      <form id="form-despesas" method="POST">
        <div class="input-group">
          <div class="input-box">
            <label for="data-pagamento">Data Pagamento</label>
            <input type="date" id="data-pagamento" name="data_pagamento" required>
          </div>

          <div class="input-box">
            <label for="data-pagamento">Data de Vencimento</label>
            <input type="date" id="data-pagamento" name="data_vencimento" required>
          </div>

          <div class="input-box">
            <label for="nome">Categoria</label>
            <select name="categoria" required>
              <option value="">Selecione</option>
              <option value="Água">Água</option>
              <option value="Energia">Energia</option>
              <option value="Internet">Internet</option>
            </select>
          </div>

          <div class="input-box">
            <label for="total">Valor</label>
            <input type="number" id="total" name="valor" min="0.01" step="0.01" required>
          </div>

          <div class="input-box">
          <label for="nome">Forma de pagamento</label>
          <select name="forma_pagamento" required>
            <option value="">Selecione</option>
            <?php foreach($formas_pagamento as $forma): ?>
              <option value="<?= htmlspecialchars($forma['id_forma_pagamento']) ?>">
                <?= htmlspecialchars($forma['descricao']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          </div>

          <div class="input-box">
            <label for="total">Observações</label>
            <input type="text" id="total" name="observacoes">
          </div>
        </div>

        <div class="criar-btn">
          <button type="submit" class="btn-cadastrar">Cadastrar</button>
        </div>
      </form>
    </div>
  </main>
</div>

<div id="mensagem-sucesso" style="display:none; color: green; margin-top: 1rem;"></div>

<script>
  // Modal sair
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

  // Modal excluir com validação
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

  const valorInput = document.getElementById('total');

  valorInput.addEventListener('input', () => {
    valorInput.setCustomValidity('');
  });

  valorInput.addEventListener('invalid', () => {
    if (valorInput.validity.valueMissing) {
      valorInput.setCustomValidity('Por favor, informe o valor da despesa.');
    } else if (valorInput.validity.rangeUnderflow) {
      valorInput.setCustomValidity('O valor deve ser maior que zero.');
    } else if (valorInput.validity.stepMismatch) {
      valorInput.setCustomValidity('O valor deve ser um número com até duas casas decimais.');
    } else {
      valorInput.setCustomValidity('Valor inválido.');
    }
  });

  document.getElementById('form-despesas').addEventListener('submit', function(e) {
  const dataPagamento = document.querySelector('input[name="data_pagamento"]').value;
  const dataVencimento = document.querySelector('input[name="data_vencimento"]').value;

  if (dataVencimento < dataPagamento) {
    e.preventDefault(); 
    alert('A data de vencimento não pode ser menor do que a data de pagamento.');
  }
});

document.getElementById('form-despesas').addEventListener('submit', function(e) {
  e.preventDefault();

  const dataPagamento = this.querySelector('input[name="data_pagamento"]').value;
  const dataVencimento = this.querySelector('input[name="data_vencimento"]').value;

  if (dataVencimento < dataPagamento) {
    alert('A data de vencimento não pode ser menor do que a data de pagamento.');
    return;
  }

  const formData = new FormData(this);

  fetch('../src/despesas/cadastrar-despesa-fixa.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(text => {
    const mensagemDiv = document.getElementById('mensagem-sucesso');

    if (text.includes("sucesso")) {
      mensagemDiv.style.color = 'green';
      mensagemDiv.textContent = "Receita foi salva com sucesso!";
      mensagemDiv.style.display = 'block';
      this.reset(); 
    } else {
      mensagemDiv.style.color = 'red';
      mensagemDiv.textContent = "Erro ao salvar a receita.";
      mensagemDiv.style.display = 'block';
    }
  })
  .catch(error => {
    const mensagemDiv = document.getElementById('mensagem-sucesso');
    mensagemDiv.style.color = 'red';
    mensagemDiv.textContent = "Erro de conexão, tente novamente.";
    mensagemDiv.style.display = 'block';
  });
});
</script>

<script src="../assets/js/inatividade.js"></script>

</body>
</html>
