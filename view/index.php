<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Enviar WhatsApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
</head>
<body>

    <form id="container-box" action="../controller/ContatoController.php" method="POST" class="p-4">
        <img src="../public/images/gpconnect.png" alt="Logo">
        <h2 class="text-center mb-4">Enviar mensagem no WhatsApp</h2>

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" id="name" name="nome" class="form-control" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="phoneNumber">Número de telefone</label>
            <input type="text" id="phoneNumber" name="telefone" class="form-control" required maxlength="20">
        </div>

        <input type="hidden" id="dataHora" name="dataHora">

        <div class="form-group">
            <label for="text">Mensagem</label>
            <textarea id="text" name="mensagem" class="form-control" required maxlength="300">Mensagem enviada</textarea>
            <small class="form-text text-muted"><span id="charCount">300</span> caracteres restantes</small>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <button id="botao-salvar" type="submit" class="btn btn-primary">Salvar Contato</button>
            <button id="botao-enviar" type="button" class="btn btn-success" disabled>Enviar WhatsApp</button>
        </div>
    </form>

    <!-- JS -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/main.js"></script>
</body>
</html>