document.addEventListener("DOMContentLoaded", () => {
  const cepInput = document.getElementById('cep');
  if (cepInput) {
    cepInput.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        this.blur();
      }
    });
  }
});
