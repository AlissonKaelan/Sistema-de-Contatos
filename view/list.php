<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';

$db = (new Database())->getConnection();
$contatoModel = new Contato($db);

$query = $db->query("SELECT * FROM contatos ORDER BY id DESC");
$contatos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Contatos</title>

  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../public/css/list.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <header class="my-3">
      <button class="btn btn-outline-secondary" onclick="window.location.href='index.php'">Voltar</button>
    </header>

    <h1 class="mb-4">Lista de Contatos</h1>

    <ul class="contact-list list-group mb-4">
      <?php foreach ($contatos as $contato): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="contact-info">
            <h5 class="mb-1"><?= htmlspecialchars($contato['nome']) ?></h5>
            <p class="mb-0"><?= htmlspecialchars($contato['telefone']) ?></p>
          </div>
          <div class="action-buttons btn-group">
            <a href="tel:<?= preg_replace('/\D/', '', $contato['telefone']) ?>" class="btn btn-sm btn-outline-primary" title="Ligar">
              <i class="fas fa-phone"></i>
            </a>
            <a href="https://wa.me/55<?= preg_replace('/\D/', '', $contato['telefone']) ?>?text=<?= urlencode($contato['mensagem']) ?>" target="_blank" class="btn btn-sm btn-outline-success" title="Enviar mensagem">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a href="editar_contato.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar contato">
              <i class="fas fa-edit"></i>
            </a>
            <a href="excluir.php?id=<?= $contato['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir contato" onclick="return confirm('Tem certeza que deseja excluir este contato?')">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="text-end mb-3">
      <a href="adicionar_contato.php" target="_blank" class="btn btn-primary">
        <i class="fas fa-user-plus me-1"></i> Adicionar Contato
      </a>
    </div>
  </div>
</body>
</html>