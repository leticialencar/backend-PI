document.addEventListener("DOMContentLoaded", () => {
  fetch('get-username.php')
    .then(res => res.json())
    .then(data => {
      if (data.nome && data.documento) {
        document.getElementById('user-info').textContent = 
          `${data.nome} (${data.documento})`;
      } else {
        document.getElementById('user-info').textContent = 'Erro ao carregar usuário';
      }
    })
    .catch(() => {
      document.getElementById('user-info').textContent = 'Erro ao carregar usuário';
    });
});
