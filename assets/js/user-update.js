document.querySelectorAll(".btn-edit").forEach(button => {
  button.addEventListener("click", (e) => {
    const row = e.target.closest("tr");
    const nomeCompleto = row.children[1].textContent.trim().split(" ");
    const email = row.children[2].textContent.trim();

    document.getElementById("nome").value = nomeCompleto[0];
    document.getElementById("sobrenome").value = nomeCompleto.slice(1).join(" ");
    document.getElementById("cpf").value = "";
    document.getElementById("email").value = email;
    document.getElementById("cargo").value = "";
    document.getElementById("nivel").value = "";

    const submitButton = document.querySelector("#modal-cadastro .criar-btn button");
    submitButton.textContent = "Alterar Informações";

    document.getElementById("modal-cadastro").classList.remove("hidden");
  });
});

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
