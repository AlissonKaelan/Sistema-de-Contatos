<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Contatos</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/list.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
</head>
<body>
  <div class="container">
    <header>
      <button onclick="window.history.back()">Voltar</button>
    </header>
    
    <h1>Lista de Contatos</h1>
    
    <ul class="contact-list">
      <li>
        <div class="contact-info">
          <h3>João Silva</h3>
          <p>(11) 98765-4321</p>
        </div>
        <div class="action-buttons">
          <button class="call" title="Ligar">Ligar</button>
          <button class="message" title="Enviar mensagem">Mensagem</button>
          <button class="edit" title="Editar contato">Editar</button>
          <button class="delete" title="Excluir contato">Excluir</button>
        </div>
      </li>
      <li>
        <div class="contact-info">
          <h3>Maria Oliveira</h3>
          <p>(21) 91234-5678</p>
        </div>
        <div class="action-buttons">
          <button class="call" title="Ligar">Ligar</button>
          <button class="message" title="Enviar mensagem">Mensagem</button>
          <button class="edit" title="Editar contato">Editar</button>
          <button class="delete" title="Excluir contato">Excluir</button>
        </div>
      </li>
      <li>
        <div class="contact-info">
          <h3>Carlos Souza</h3>
          <p>(31) 99876-5432</p>
        </div>
        <div class="action-buttons">
          <button class="call" title="Ligar">Ligar</button>
          <button class="message" title="Enviar mensagem">Mensagem</button>
          <button class="edit" title="Editar contato">Editar</button>
          <button class="delete" title="Excluir contato">Excluir</button>
        </div>
      </li>
    </ul>
    
    <div class="add-contact">
      <button onclick="alert('Função para adicionar novo contato')">Adicionar Contato</button>
    </div>
  </div>
</body>
</html>
