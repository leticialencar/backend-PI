function atualizarNomeTopo() {
  fetch('get-username.php')
    .then(res => res.json())
    .then(data => {
      if (data.nome && data.documento) {
        document.getElementById('user-info').textContent = 
          `${data.nome} (${data.documento})`;
      }
    });
}

document.getElementById('nome').addEventListener('input', function() {
  const nomeDigitado = this.value.trim();
  if (nomeDigitado) {
    document.getElementById('user-info').textContent = nomeDigitado + ' (não salvo)';
  } else {
    document.getElementById('user-info').textContent = 'Carregando usuário...';
  }
});

document.getElementById('form-dados').addEventListener('submit', function(event) {
  event.preventDefault();
  const form = event.target;
  const formData = new FormData(form);

  fetch(form.action, {
    method: form.method,
    body: formData,
    credentials: 'same-origin'
  })
  .then(response => response.json())
  .then(data => {
    const mensagemDiv = document.getElementById('mensagem');
    if(data.status === 'success'){
      mensagemDiv.style.color = 'green';
      mensagemDiv.textContent = data.message;

      atualizarNomeTopo();
    } else {
      mensagemDiv.style.color = 'red';
      mensagemDiv.textContent = data.message;
    }
  })
  .catch(error => {
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.style.color = 'red';
    mensagemDiv.textContent = 'Erro na comunicação com o servidor.';
    console.error('Erro:', error);
  });
});
