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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">Lista de Contatos</h2>
    <a href="index.php" class="btn btn-secondary mb-3">
      <i class="fas fa-arrow-left me-1"></i>Voltar
    </a>
    <a href="adicionar_contato.php" class="btn btn-primary mb-3">
      <i class="fas fa-user-plus me-1"></i> Novo Contato
    </a>
    <table class="table table-bordered table-striped bg-white">
      <thead class="table-dark">
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
            <td>
              <a href="editar_contato.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
              </a>
              <a href="../controller/excluir.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">
                <i class="fas fa-trash"></i>  
              </a>
              <a href="https://wa.me/55<?= preg_replace('/\D/', '', $contato['telefone']) ?>?text=<?= urlencode($contato['mensagem']) ?>" target="_blank" class="btn btn-sm btn-success">
                <i class="fab fa-whatsapp"></i>
              </a>
            </td> 
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

      
      <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 2): ?>
        <div class="alert alert-success">Contato excluído com sucesso!</div>
      <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 2): ?>
        <div class="alert alert-danger">Erro ao excluir o contato.</div>
      <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
        <div class="alert alert-warning">ID inválido para exclusão.</div>
      <?php endif; ?>
      
</body>
</html>