<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Contato</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome para ícones (opcional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card shadow-sm rounded">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Adicionar Novo Contato</h4>
          </div>

          <div class="card-body">
            <form action="../controller/ContatoController.php" method="POST">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required maxlength="100">
              </div>

              <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="(84) 99123-4567" required maxlength="20">
              </div>

              <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea name="mensagem" id="mensagem" class="form-control" rows="3" required maxlength="300">Mensagem enviada</textarea>
              </div>

              <input type="hidden" name="dataHora" id="dataHora">

              <div class="d-flex justify-content-between">
                <a href="list.php" class="btn btn-secondary">
                  <i class="fas fa-arrow-left me-1"></i>Voltar
                </a>
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-save me-1"></i>Salvar Contato
                </button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Preenche automaticamente o campo dataHora -->
  <script>
    document.getElementById('dataHora').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
  </script>

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
