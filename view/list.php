<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';
require_once '../utils/funcoes.php';

$db = (new Database())->getConnection();
$contato = new Contato($db);

// Paginação
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite_por_pagina = 10;
$offset = ($pagina_atual - 1) * $limite_por_pagina;

// Total de registros
$total_registros = $db->query("SELECT COUNT(*) FROM contatos")->fetchColumn();
$total_paginas = ceil($total_registros / $limite_por_pagina);

// Consulta paginada
$query = $db->prepare("SELECT * FROM contatos ORDER BY id DESC LIMIT :limite OFFSET :offset");
$query->bindValue(':limite', $limite_por_pagina, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
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
                <th class="sortable" data-column="0">Nome <i class="fa-solid fa-sort"></i></th>
                <th class="sortable" data-column="1">Telefone <i class="fa-solid fa-sort"></i></th>
                <th class="sortable" data-column="2">Mensagem <i class="fa-solid fa-sort"></i></th>
                <th class="sortable" data-column="3">Data de Criação <i class="fa-solid fa-sort"></i></th>
                <th class="sortable" data-column="4">Data de Atualização <i class="fa-solid fa-sort"></i></th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
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
