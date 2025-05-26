document.addEventListener("DOMContentLoaded", () => {
  const formCadastro = document.querySelector("#modal-cadastro .modal-form-new-user form");
  const tabelaUsuarios = document.querySelector(".card table tbody");

  // Abrir modal e limpar formulário ao clicar em abrir cadastro
  document.querySelector(".open-modal[data-modal='modal-cadastro']").addEventListener("click", () => {
    document.querySelectorAll("#modal-cadastro input").forEach(input => input.value = "");
    document.querySelector("#cargo").value = "";
    document.querySelector("#nivel").value = "";

    const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
    submitButton.textContent = "Criar Conta";

    document.getElementById("modal-cadastro").classList.remove("hidden");
  });

  // Editar usuário - preencher modal com dados da linha clicada
  tabelaUsuarios.addEventListener("click", (e) => {
    if (e.target.classList.contains("btn-edit")) {
      const row = e.target.closest("tr");
      const nomeCompleto = row.children[1].textContent.trim().split(" ");
      const email = row.children[2].textContent.trim();

      document.getElementById("nome").value = nomeCompleto[0];
      document.getElementById("sobrenome").value = nomeCompleto.slice(1).join(" ");
      document.getElementById("cpf").value = ""; // se tiver info, colocar aqui
      document.getElementById("email").value = email;
      document.getElementById("cargo").value = "";
      document.getElementById("nivel").value = "";

      const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
      submitButton.textContent = "Alterar Informações";

      document.getElementById("modal-cadastro").classList.remove("hidden");
    }
  });

  // Enviar formulário - criar ou atualizar usuário
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
        alert("Usuário salvo com sucesso!");
        location.reload();
      } else {
        alert("Erro ao salvar o usuário.");
      }
    } catch (error) {
      console.error("Erro ao salvar o usuário:", error);
      alert("Erro de conexão.");
    }

    const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
    submitButton.textContent = "Criar Conta";

    document.getElementById("modal-cadastro").classList.add("hidden");
  });
});
