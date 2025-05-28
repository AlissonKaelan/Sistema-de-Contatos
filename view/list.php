<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';

$db = (new Database())->getConnection();
$contato = new Contato($db);

$query = $db->query("SELECT * FROM contatos ORDER BY id DESC");
$contatos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Contatos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Estilo personalizado -->
  <link href="../public/css/style.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Lista de Contatos</h4>
        <div>
          <a href="index.php" class="btn btn-outline-light me-2">
            <i class="fas fa-arrow-left me-1"></i>Voltar
          </a>
          <a href="adicionar_contato.php" class="btn btn-light text-primary">
            <i class="fas fa-user-plus me-1"></i>Novo Contato
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Mensagem</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contatos as $contato): ?>
              <tr>
                <td><?= htmlspecialchars($contato['nome']) ?></td>
                <td><?= htmlspecialchars($contato['telefone']) ?></td>
                <td><?= htmlspecialchars($contato['mensagem']) ?></td>
                <td class="text-center">
                  <a href="editar_contato.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-warning me-1" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="../controller/excluir.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-danger me-1" title="Excluir"
                     onclick="return confirm('Tem certeza que deseja excluir?')">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a href="https://wa.me/55<?= preg_replace('/\D/', '', $contato['telefone']) ?>?text=<?= urlencode($contato['mensagem']) ?>" 
                     target="_blank" class="btn btn-sm btn-success" title="Enviar WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Alerta PHP -->
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 2): ?>
      <script>Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Contato excluído com sucesso.' });</script>
    <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 2): ?>
      <script>Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao excluir o contato.' });</script>
    <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
      <script>Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'ID inválido para exclusão.' });</script>
    <?php endif; ?>

    <!-- Limpar URL após alerta -->
    <?php if (isset($_GET['sucesso']) || isset($_GET['erro'])): ?>
      <script>window.history.replaceState({}, document.title, window.location.pathname);</script>
    <?php endif; ?>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>