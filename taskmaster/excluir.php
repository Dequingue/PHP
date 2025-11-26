<?php
require 'config.php';
proteger_pagina();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    $_SESSION['flash_msg'] = 'ID inválido.';
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM tarefas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_msg'] = 'Tarefa excluída.';
} else {
    $_SESSION['flash_msg'] = 'Erro ao excluir: ' . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
header('Location: index.php');
exit;
