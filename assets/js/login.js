document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    if (params.get('erro') === '1') {
        const errorMessage = document.createElement('p');
        errorMessage.textContent = 'Dados de login incorretos. Verifique seu usuário e senha.';

        errorMessage.style.color = '#FF0000';
        errorMessage.style.fontSize = '0.9rem';
        errorMessage.style.marginTop = '10px';
        errorMessage.style.textAlign = 'center';

        const btnContainer = document.getElementById('login-btn-container');
        if (btnContainer) {
            btnContainer.insertAdjacentElement('afterend', errorMessage);
        }
    }
});
