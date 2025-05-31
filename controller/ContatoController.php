<?php

require_once '../config/database.php';
require_once '../model/Contato.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Define fuso horário
    date_default_timezone_set('America/Sao_Paulo');

    // 2. Recebe e trata os dados do formulário
    $nome     = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''));
    $mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));

    // 3. Gera a data e hora atual no servidor
    $dataHora = date('Y-m-d H:i:s');

    // 4. Verifica se os campos obrigatórios foram preenchidos
    if (!$nome || !$telefone || !$mensagem) {
        header("Location: ../view/index.php?erro=2");
        exit;
    }

    // 5. Validação do formato de telefone
    function telefoneValido($telefone) {
        return preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone);
    }

    if (!telefoneValido($telefone)) {
        header("Location: ../view/index.php?erro=4");
        exit;
    }

    // 6. Conecta ao banco e prepara o objeto
    $db = (new Database())->getConnection();
    $contato = new Contato($db);

    // 7. Verifica duplicidade
    if ($contato->telefoneExiste($telefone)) {
        header("Location: ../view/index.php?erro=3");
        exit;
    }

    // 8. Salva o contato
    if ($contato->salvar($nome, $telefone, $mensagem, $dataHora)) {
        header("Location: ../view/index.php?sucesso=1");
    } else {
        header("Location: ../view/index.php?erro=1");
    }

    exit;

} else {
    // Se não for POST, redireciona
    header("Location: ../view/index.php");
    exit;
}