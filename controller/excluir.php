<?php
require_once '../config/database2.php';
require_once '../model/Contato.php';

// Verifica se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list2.php?erro=1"); // erro: ID inválido
    exit;
}

$id = $_GET['id'];

// Conecta ao banco e prepara o modelo
$db = (new Database())->getConnection();
$contatoModel = new Contato($db);

// Executa a exclusão
if ($contatoModel->excluir($id)) {
    header("Location: list2.php?sucesso=2"); // sucesso: contato excluído
} else {
    header("Location: list2.php?erro=2"); // erro: falha ao excluir
}
exit;