document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('container-box');
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    const botaoSalvar = document.getElementById('botao-salvar');
    const botaoEnviar = document.getElementById('botao-enviar');
    const phoneInput = document.getElementById('phoneNumber');
    const textarea = document.getElementById('text');
    const charCount = document.getElementById('charCount');
    const maxLength = textarea.getAttribute('maxlength');

    function validarCampos() {
        const valido = Array.from(inputs).every(input => input.value.trim() !== "");
        botaoEnviar.disabled = !valido;
        botaoSalvar.disabled = !valido;
    }

    inputs.forEach(input => input.addEventListener('input', validarCampos));
    window.addEventListener('load', validarCampos);

    textarea.addEventListener('input', () => {
        charCount.textContent = maxLength - textarea.value.length;
    });

    phoneInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        value = value.length <= 10
            ? value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3')
            : value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
        e.target.value = value;
    });

    botaoEnviar.addEventListener('click', function () {
        const rawNumber = phoneInput.value.replace(/\D/g, '');
        const message = encodeURIComponent(textarea.value.trim());

        if (!/^\d{10,11}$/.test(rawNumber)) {
            Swal.fire({ title: 'Número inválido!', text: 'Digite um número com DDD.', icon: 'error' });
            return;
        }

        const url = `https://wa.me/55${rawNumber}?text=${message}`;
        window.open(url, '_blank');
    });

    ['phoneNumber', 'text'].forEach(id => {
        document.getElementById(id).addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                botaoEnviar.click();
            }
        });
    });

    form.addEventListener('submit', function () {
        const now = new Date();
        const formatado = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')} ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
        document.getElementById('dataHora').value = formatado;
    });
});