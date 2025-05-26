<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';

$db = (new Database())->getConnection();
$contatoModel = new Contato($db);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $db->prepare("SELECT * FROM contatos WHERE id = ?");
$stmt->execute([$id]);
$contato = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $mensagem = $_POST['mensagem'];

    $update = $db->prepare("UPDATE contatos SET nome=?, telefone=?, mensagem=? WHERE id=?");
    $update->execute([$nome, $telefone, $mensagem, $id]);

    header("Location: list.php?sucesso=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Contato</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">Editar Contato</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($contato['nome']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($contato['telefone']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Mensagem</label>
        <textarea name="mensagem" class="form-control" required><?= htmlspecialchars($contato['mensagem']) ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
      </div>
    </form>
  </div>
</body>
</html>