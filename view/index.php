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
    <div class="container">
        <h1 class="text-center mb-4">Formulário de Contato</h1>
        <p class="text-center">Preencha os campos abaixo para enviar uma mensagem no WhatsApp.</p>

    <form id="container-box" action="../controller/ContatoController.php" method="POST" class="p-4">
        <a href="list.php" class="btn btn-secondary mb-3">Lista de Contatos</a>
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
            <button id="botao-enviar" type="button" class="btn btn-success" disabled>
        <i class="fab fa-whatsapp"></i> Enviar WhatsApp
        </button>

        <!-- Ícone do WhatsApp (adicionar ao <head>) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        </div>
    </form>

    <!-- JS -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/main.js"></script>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Sucesso!',
      text: 'Contato salvo com sucesso.',
      confirmButtonColor: '#3085d6'
    });
  </script>
    <?php elseif (isset($_GET['erro'])): ?>
      <?php if ($_GET['erro'] == 1): ?>
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Erro ao salvar o contato. Tente novamente.',
            confirmButtonColor: '#d33'
          });
        </script>
      <?php elseif ($_GET['erro'] == 2): ?>
        <script>
          Swal.fire({
            icon: 'warning',
            title: 'Campos obrigatórios',
            text: 'Por favor, preencha todos os campos antes de enviar.',
            confirmButtonColor: '#f39c12'
          });
        </script>
      <?php elseif ($_GET['erro'] == 3): ?>
        <script>
          Swal.fire({
            icon: 'info',
            title: 'Número já cadastrado',
            text: 'Este número de telefone já está registrado.',
            confirmButtonColor: '#17a2b8'
          });
        </script>

      <?php elseif ($_GET['erro'] == 4): ?>
      <script>
        Swal.fire({
          icon: 'warning',
          title: 'Telefone inválido',
          text: 'Digite um número de telefone válido, como (11) 91234-5678.',
          confirmButtonColor: '#f39c12'
        });
      </script>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Limpa a URL -->
    <?php if (isset($_GET['sucesso']) || isset($_GET['erro'])): ?>
    <script>
      window.history.replaceState({}, document.title, window.location.pathname);
    </script>
    <?php endif; ?>
    
</body>
</html>