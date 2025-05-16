<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('database.php');

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $mensagem = trim($_POST['mensagem']);
    $dataHora = trim($_POST['dataHora']);

    $stmt = $con->prepare("INSERT INTO contatos (nome, telefone, mensagem, data_hora) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $telefone, $mensagem, $dataHora);
        $stmt->execute();
        $stmt->close();
    } else {
        // Opcional: log ou tratamento de erro
        error_log("Erro no prepare: " . $con->error);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar WhatsApp</title>

    <!-- Estilos externos -->
    <link href="../../vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../vendor/icomoon/css/iconfont.min.css" rel="stylesheet">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../js/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="css/index.css"> <!-- Corrigido caminho -->
</head>
<body>

    <form id="container-box" action="index.php" method="POST" class="p-4">
        <img src="images/gpconnect.png" alt="Logo" class="mb-3">
        <h1 class="mb-4">Enviar mensagem no WhatsApp</h1>

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" id="name" name="nome" class="form-control" placeholder="Digite o nome" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="phoneNumber">Número de telefone</label>
            <input type="text" id="phoneNumber" name="telefone" class="form-control" placeholder="Digite o número com DDD (ex: 84900000000)" required maxlength="20">
        </div>

        <input type="hidden" id="dataHora" name="dataHora">

        <div class="form-group">
            <label for="text">Mensagem para ser enviada</label>
            <textarea id="text" name="mensagem" class="form-control input-message" required maxlength="300">Mensagem enviada</textarea>
            <small class="form-text text-muted text-right"><span id="charCount">250</span> caracteres restantes</small>
        </div>

        <button id="botao-enviar" type="button" class="btn btn-success mt-3" disabled>Enviar</button>
    </form>

    <!-- Scripts -->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('container-box');
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        const botao = document.getElementById('botao-enviar');
        const phoneInput = document.getElementById('phoneNumber');
        const textarea = document.getElementById('text');
        const charCount = document.getElementById('charCount');
        const maxLength = textarea.getAttribute('maxlength');

        // Valida campos obrigatórios
        function validarCampos() {
            const valido = Array.from(inputs).every(input => input.value.trim() !== "");
            botao.disabled = !valido;
        }

        inputs.forEach(input => input.addEventListener('input', validarCampos));
        window.addEventListener('load', validarCampos);

        // Máscara de telefone
        phoneInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);

            value = value.length <= 10
                ? value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3')
                : value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');

            e.target.value = value;
        });

        // Contador de caracteres da mensagem
        textarea.addEventListener('input', () => {
            charCount.textContent = maxLength - textarea.value.length;
        });

        // Botão de envio com SweetAlert
        botao.addEventListener('click', function () {
            const now = new Date();
            const formatado = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')} ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
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
                    form.submit();
                    redirectToWhatsApp();
                }
            });
        });

        function redirectToWhatsApp() {
            const rawNumber = phoneInput.value.replace(/\D/g, '');
            const message = encodeURIComponent(textarea.value.trim());

            if (!/^\d{10,11}$/.test(rawNumber)) {
                Swal.fire({
                    title: 'Número inválido!',
                    text: 'Insira um número válido com DDD (ex: 84900000000).',
                    icon: 'error'
                });
                return;
            }

            const url = `https://wa.me/55${rawNumber}?text=${message}`;
            window.open(url, '_blank');
        }

        // Impede Enter de enviar antes da confirmação
        ['phoneNumber', 'text'].forEach(id => {
            document.getElementById(id).addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    redirectToWhatsApp();
                }
            });
        });
    </script>
</body>
</html>