const tempoInatividade = 2000000;
let timeout;

function mostrarToastESair() {
    const toast = document.getElementById("session-expired-toast");
    if (toast) {
        toast.classList.remove("hidden");
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
            toast.classList.add("hidden");
            window.location.href = '../public/login.html';
        }, 3000);
    } else {
        console.warn("Elemento #session-expired-toast não encontrado.");
    }
}

function iniciarTemporizador() {
    clearTimeout(timeout);
    timeout = setTimeout(mostrarToastESair, tempoInatividade);
}

['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evento => {
    document.addEventListener(evento, iniciarTemporizador);
});

iniciarTemporizador();
