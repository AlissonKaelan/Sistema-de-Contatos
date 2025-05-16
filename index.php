<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once('database.php');
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $mensagem = $_POST['mensagem'];
    $dataHora = $_POST['dataHora'];

    $result = mysqli_query($con, "INSERT INTO contatos (nome, telefone, mensagem, data_hora) VALUES ('$nome', '$telefone', '$mensagem', '$dataHora')");

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wa.me Redirect</title>

    <link href="../../vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../vendor/icomoon/css/iconfont.min.css" rel="stylesheet">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../js/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/..css/index.css">
</head>
<body>

    <form id="container-box" action="index.php" method="POST">
        <img src="images/gpconnect.png" alt="Logo"> 
        <h1 class="mb-5">Enviar mensagem no WhatsApp</h1>

        <h2>Nome</h2>
        <div style="text-align: left;">
        <input type="text" id="name" placeholder="Digite o nome" name="nome" required maxlength="100">
        </div>
        
        <h2>Número de telefone</h2>
        <div style="text-align: left;">
        <input type="text" id="phoneNumber" placeholder="Digite o número com DDD (ex: 84900000000)" name="telefone" required maxlength="20">
        </div>

        <input type="hidden" id="dataHora" name="dataHora">

        <div style="text-align: right; font-size: 14px; color: #666;">
            <span id="charCount">250</span> caracteres restantes
        </div>

        
	<h2>Mensagem para ser enviada</h2>
        <div class="input-container">
            <textarea id="text" class="input-message" name="mensagem" required maxlength="300">Mensagem enviada</textarea>

    
        </div>

        <br>
        <button id="botao-enviar" type="button" disabled>Enviar</button>
    </form>


    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        const form = document.getElementById('container-box');
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        const botao = document.getElementById('botao-enviar');

        function validarCampos() {
            let formValido = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    formValido = false;
                }
            });

            botao.disabled = !formValido;
        }

        // Monitora todos os campos obrigatórios
        inputs.forEach(input => {
            input.addEventListener('input', validarCampos);
        });

        // Verifica logo ao carregar a página também
        window.addEventListener('load', validarCampos);

        document.getElementById('phoneNumber').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos

            // Formata como (84) 90000-0000
            if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }

            e.target.value = value;
        });

        const textarea = document.getElementById('text');
        const charCount = document.getElementById('charCount');
        const maxLength = textarea.getAttribute('maxlength');

        textarea.addEventListener('input', () => {
            const remaining = maxLength - textarea.value.length;
            charCount.textContent = remaining;
        });

        document.getElementById('botao-enviar').addEventListener('click', function () {
            const now = new Date();

            // Formatar a data para o padrão 'YYYY-MM-DD HH:MM:SS'
            const ano = now.getFullYear();
            const mes = String(now.getMonth() + 1).padStart(2, '0'); // Meses começam do 0, por isso somamos 1
            const dia = String(now.getDate()).padStart(2, '0');
            const hora = String(now.getHours()).padStart(2, '0');
            const minuto = String(now.getMinutes()).padStart(2, '0');
            const segundo = String(now.getSeconds()).padStart(2, '0');

            const formatado = `${ano}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;

            // Agora você pode enviar 'formatado' para o banco de dados
            document.getElementById('dataHora').value = formatado;
            Swal.fire({
                title: 'Deseja cadastrar o usuário?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                customClass: {
                    confirmButton: 'botao-sim',
                    cancelButton: 'botao-nao'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('container-box').submit();
                    redirectToWhatsApp();
                }
            });
        });


        function redirectToWhatsApp() {
            const userNumber = document.getElementById('phoneNumber').value.trim();
            const messageInput = document.getElementById('text');
            const sanitizedNumber = userNumber.replace(/\D/g, '');

            if (!/^\d{10,11}$/.test(sanitizedNumber)) {
                Swal.fire({
                    title: 'Número inválido!',
                    text: 'Insira um número válido com DDD (ex: 84900000000).',
                    icon: 'error'
                });
                return;
            }

            const fullNumber = `55${sanitizedNumber}`;
            const message = encodeURIComponent(messageInput.value.trim());
            const url = `https://wa.me/${fullNumber}?text=${message}`;

            window.open(url, '_blank');
        }

        function mostrarDiv() {
            const popup = document.querySelector('.pop-up');
            popup.style.display = 'block';
        }

        function enableMessageEdit() {
            const messageInput = document.getElementById('text');
            messageInput.disabled = false;
            messageInput.focus();
            document.getElementById('editMessageBtn').style.display = 'none';
        }

        ['phoneNumber', 'text'].forEach(function(id) {
            document.getElementById(id).addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Impede envio com Enter
                    redirectToWhatsApp();
                }
            });
        });
    </script>

</body>
</html>
