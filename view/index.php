<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Enviar WhatsApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="../public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulário de Contato</h1>
        <p class="text-center">Preencha os campos abaixo para enviar uma mensagem no WhatsApp.</p>

        <form id="container-box" action="../controller/ContatoController.php" method="POST" class="p-4 border rounded bg-light">
            <a href="list.php" class="btn btn-secondary mb-3">Lista de Contatos</a>
            <h2 class="text-center mb-4">Enviar mensagem no WhatsApp</h2>

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" id="name" name="nome" class="form-control" required maxlength="100">
            </div>

            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Número de telefone</label>
                <input type="tel" id="phoneNumber" name="telefone" class="form-control" required
                       pattern="\(\d{2}\)\s\d{4,5}-\d{4}" placeholder="(11) 91234-5678">
            </div>

            <input type="hidden" id="dataHora" name="dataHora">

            <div class="mb-3">
                <label for="text" class="form-label">Mensagem</label>
                <textarea id="text" name="mensagem" class="form-control" required maxlength="300">Mensagem enviada</textarea>
                <small class="form-text text-muted"><span id="charCount">300</span> caracteres restantes</small>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button id="botao-salvar" type="submit" class="btn btn-primary">Salvar Contato</button>
                <button id="botao-enviar" type="button" class="btn btn-success" disabled>
                    <i class="fab fa-whatsapp"></i> Enviar WhatsApp
                </button>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="../public/js/main.js"></script>

    <!-- PHP para mensagens -->
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <script>
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Contato salvo com sucesso.' });
        </script>
    <?php elseif (isset($_GET['erro'])): ?>
        <?php if ($_GET['erro'] == 1): ?>
            <script>Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao salvar o contato.' });</script>
        <?php elseif ($_GET['erro'] == 2): ?>
            <script>Swal.fire({ icon: 'warning', title: 'Campos obrigatórios', text: 'Preencha todos os campos.' });</script>
        <?php elseif ($_GET['erro'] == 3): ?>
            <script>Swal.fire({ icon: 'info', title: 'Número já cadastrado', text: 'Esse telefone já está salvo.' });</script>
        <?php elseif ($_GET['erro'] == 4): ?>
            <script>Swal.fire({ icon: 'warning', title: 'Telefone inválido', text: 'Digite um número válido.' });</script>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Limpa a URL após o alerta -->
    <?php if (isset($_GET['sucesso']) || isset($_GET['erro'])): ?>
        <script>window.history.replaceState({}, document.title, window.location.pathname);</script>
    <?php endif; ?>
</body>
</html>