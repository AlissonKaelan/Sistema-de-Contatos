<?php
require_once '../config/database.php';
require_once '../model/Contato.php';

// Verifica se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../view/list.php?erro=1");
    exit;
}

$id = $_GET['id'];

$db = (new Database())->getConnection();
$contatoModel = new Contato($db);

if ($contatoModel->excluir($id)) {
    header("Location: ../view/list.php?sucesso=2");
} else {
    header("Location: ../view/list.php?erro=2");
}
exit;