<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''));
    $mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));
    $dataHora = htmlspecialchars(trim($_POST['dataHora'] ?? date('Y-m-d H:i:s')));

    // Verificação básica de campos obrigatórios
    if ($nome && $telefone && $mensagem && $dataHora) {
        $db = (new Database())->getConnection();
        $contato = new Contato($db);

        // Verifica se o telefone já está cadastrado
        if ($contato->telefoneExiste($telefone)) {
            header("Location: ../view/index.php?erro=3"); // Número duplicado
            exit;
        }

        function telefoneValido($telefone) {
        return preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone);
        }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome     = htmlspecialchars(trim($_POST['nome'] ?? ''));
        $telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''));
        $mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));
        $dataHora = htmlspecialchars(trim($_POST['dataHora'] ?? date('Y-m-d H:i:s')));

        if (!$nome || !$telefone || !$mensagem || !$dataHora) {
            header("Location: ../view/index.php?erro=2");
            exit;
        }

        if (!telefoneValido($telefone)) {
            header("Location: ../view/index.php?erro=4"); // Novo código de erro
            exit;
        }

        $db = (new Database())->getConnection();
        $contato = new Contato($db);

        if ($contato->telefoneExiste($telefone)) {
            header("Location: ../view/index.php?erro=3");
            exit;
        }

        if ($contato->salvar($nome, $telefone, $mensagem, $dataHora)) {
            header("Location: ../view/index.php?sucesso=1");
        } else {
            header("Location: ../view/index.php?erro=1");
        }
        exit;
    }

        // Tenta salvar o contato
        if ($contato->salvar($nome, $telefone, $mensagem, $dataHora)) {
            header("Location: ../view/index.php?sucesso=1");
        } else {
            header("Location: ../view/index.php?erro=1"); // Erro ao salvar
        }
        exit;
    } else {
        header("Location: ../view/index.php?erro=2"); // Campos obrigatórios não preenchidos
        exit;
    }
} else {
    // Se não for POST, redireciona para o index
    header("Location: ../view/index.php");
    exit;
}
?>
