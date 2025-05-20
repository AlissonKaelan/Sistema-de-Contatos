<?php
require_once '../config/database.php';
require_once '../model/Contato.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''));
    $mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));
    $dataHora = htmlspecialchars(trim($_POST['dataHora'] ?? date('Y-m-d H:i:s')));

    if ($nome && $telefone && $mensagem && $dataHora) {
        $db = (new Database())->getConnection();
        $contato = new Contato($db);

        if ($contato->salvar($nome, $telefone, $mensagem, $dataHora)) {
            header("Location: ../view/index.php?sucesso=1");
        } else {
            header("Location: ../view/index.php?erro=1");
        }
        exit;
    } else {
        header("Location: ../view/index.php?erro=2");
        exit;
    }
} else {
    header("Location: ../view/index.php");
    exit;
}
?>