

    console.log("Session Manager Script Loaded");
    const tempoInatividade = 10000; 
    let timeout;

    function iniciarTemporizador() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            window.location.href = '/backend/src/login/logout.php';
        }, tempoInatividade);
    }

    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evento => {
        document.addEventListener(evento, iniciarTemporizador);
    });

    iniciarTemporizador();



