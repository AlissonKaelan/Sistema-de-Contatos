<?php
require_once '../config/database.php';
require_once '../config/database2.php';

$db = (new Database())->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = $db->prepare("DELETE FROM contatos WHERE id = ?");
    $delete->execute([$id]);
}

header('Location: list.php');
exit;