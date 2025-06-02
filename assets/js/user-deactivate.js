document.addEventListener('DOMContentLoaded', () => {
    let userIdToDeactivate = null;

    document.querySelectorAll('.js-open-modal-desativar').forEach(button => {
        button.addEventListener('click', () => {
            userIdToDeactivate = button.dataset.id;
            document.getElementById('modal-1').classList.remove('hidden');
        });
    });

    document.querySelector('.sim-btn-desativar button').addEventListener('click', () => {
        if (!userIdToDeactivate) return;

        fetch('../src/profile/desativar_usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userIdToDeactivate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Erro ao desativar usuário.');
            }
        })
        .catch(() => alert('Erro na requisição.'));
    });

    document.querySelector('.nao-btn-desativar button').addEventListener('click', () => {
        document.getElementById('modal-1').classList.add('hidden');
        userIdToDeactivate = null;
    });

    document.querySelector('.js-close-modal-desativar').addEventListener('click', () => {
        document.getElementById('modal-1').classList.add('hidden');
        userIdToDeactivate = null;
    });
});
