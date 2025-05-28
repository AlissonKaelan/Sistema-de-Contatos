<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';
require_once '../utils/funcoes.php';

$db = (new Database())->getConnection();
$contato = new Contato($db);

// Receber os filtros via GET (para manter o valor no formulário)
$nome       = trim($_GET['nome'] ?? '');
$telefone   = trim($_GET['telefone'] ?? '');
$mensagem   = trim($_GET['mensagem'] ?? '');
$data_inicio = trim($_GET['data_inicio'] ?? '');
$data_fim   = trim($_GET['data_fim'] ?? '');

// Paginação
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite_por_pagina = 15;
$offset = ($pagina_atual - 1) * $limite_por_pagina;

// Construir filtros dinamicamente
$filtros = [];
$params = [];

if ($nome !== '') {
    $filtros[] = "nome LIKE :nome";
    $params[':nome'] = "%$nome%";
}
if ($telefone !== '') {
    $filtros[] = "telefone LIKE :telefone";
    $params[':telefone'] = "%$telefone%";
}
if ($mensagem !== '') {
    $filtros[] = "mensagem LIKE :mensagem";
    $params[':mensagem'] = "%$mensagem%";
}
if ($data_inicio !== '') {
    $filtros[] = "data_hora >= :data_inicio";
    $params[':data_inicio'] = $data_inicio . " 00:00:00";
}
if ($data_fim !== '') {
    $filtros[] = "data_hora <= :data_fim";
    $params[':data_fim'] = $data_fim . " 23:59:59";
}

$where = '';
if (count($filtros) > 0) {
    $where = 'WHERE ' . implode(' AND ', $filtros);
}

// Contar total de registros com filtro para paginação
$sql_count = "SELECT COUNT(*) FROM contatos $where";
$stmt_count = $db->prepare($sql_count);
foreach ($params as $key => $val) {
    $stmt_count->bindValue($key, $val);
}
$stmt_count->execute();
$total_registros = $stmt_count->fetchColumn();
$total_paginas = ceil($total_registros / $limite_por_pagina);

// Buscar contatos filtrados com paginação
$sql = "SELECT * FROM contatos $where ORDER BY id DESC LIMIT :limite OFFSET :offset";
$stmt = $db->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limite', $limite_por_pagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

      <!-- Formulário de filtro -->
      <form method="GET" class="p-3">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome" class="form-control" value="<?= htmlspecialchars($nome) ?>">
          </div>
          <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="Telefone" class="form-control" value="<?= htmlspecialchars($telefone) ?>">
          </div>
          <div class="col-md-4">
            <label for="mensagem" class="form-label">Mensagem</label>
            <input type="text" id="mensagem" name="mensagem" placeholder="Mensagem" class="form-control" value="<?= htmlspecialchars($mensagem) ?>">
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-3">
            <label for="data_inicio" class="form-label">Data Início</label>
            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= htmlspecialchars($data_inicio) ?>">
          </div>
          <div class="col-md-3">
            <label for="data_fim" class="form-label">Data Fim</label>
            <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= htmlspecialchars($data_fim) ?>">
          </div>
          <div class="col-md-6 d-flex align-items-end justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i> Filtrar
            </button>
            <a href="lista_contatos.php" class="btn btn-secondary">Limpar</a>
          </div>
        </div>
      </form>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Mensagem</th>
                <th>Data de Criação</th>
                <th>Data de Atualização</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($contatos) === 0): ?>
                <tr><td colspan="6" class="text-center">Nenhum contato encontrado.</td></tr>
              <?php else: ?>
                <?php foreach ($contatos as $contato): ?>
                  <tr>
                    <td><?= htmlspecialchars($contato['nome']) ?></td>
                    <td><?= htmlspecialchars($contato['telefone']) ?></td>
                    <td><?= htmlspecialchars($contato['mensagem']) ?></td>
                    <td><?= formatarDataHoraPtBr($contato['data_hora']) ?></td>
                    <td><?= formatarDataHoraPtBr($contato['data_update']) ?></td>
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
              <?php endif; ?>
            </tbody>
          </table>

          <!-- Paginação -->
          <div class="d-flex justify-content-center mt-4">
            <nav>
              <ul class="pagination">
                <?php
                $max_links = 10;
                $params = $_GET;

                // Botão "Anterior"
                if ($pagina_atual > 1) {
                  $params['pagina'] = $pagina_atual - 1;
                  echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($params) . '">«</a></li>';
                } else {
                  echo '<li class="page-item disabled"><span class="page-link">«</span></li>';
                }

                // Intervalo de páginas
                $start = max(1, $pagina_atual - floor($max_links / 2));
                $end = min($total_paginas, $start + $max_links - 1);
                if (($end - $start + 1) < $max_links) {
                  $start = max(1, $end - $max_links + 1);
                }

                for ($i = $start; $i <= $end; $i++) {
                  $params['pagina'] = $i;
                  $active = $i == $pagina_atual ? ' active' : '';
                  echo '<li class="page-item' . $active . '"><a class="page-link" href="?' . http_build_query($params) . '">' . $i . '</a></li>';
                }

                // Botão "Próximo"
                if ($pagina_atual < $total_paginas) {
                  $params['pagina'] = $pagina_atual + 1;
                  echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($params) . '">»</a></li>';
                } else {
                  echo '<li class="page-item disabled"><span class="page-link">»</span></li>';
                }
                ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Alertas -->
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 2): ?>
      <script>Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Contato excluído com sucesso.' });</script>
    <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 2): ?>
      <script>Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao excluir o contato.' });</script>
    <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
      <script>Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'ID inválido para exclusão.' });</script>
    <?php endif; ?>

    <!-- Limpar parâmetros da URL -->
    <?php if (isset($_GET['sucesso']) || isset($_GET['erro'])): ?>
      <script>window.history.replaceState({}, document.title, window.location.pathname);</script>
    <?php endif; ?>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../public/js/list.js"></script>
</body>
</html>
