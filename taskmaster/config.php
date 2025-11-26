<?php
// config.php
// Configurações da conexão (edite de acordo com seu ambiente)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_taskmaster';

// Conexão MySQLi procedural
$conn = mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    die('Erro ao conectar ao MySQL: ' . mysqli_connect_error());
}

// Cria o banco se não existir (seed.php também faz isso)
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Seleciona o DB
mysqli_select_db($conn, $db_name);

// Função para proteger páginas (chame no topo das páginas protegidas)
function proteger_pagina() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['usuario_id'])) {
        // redireciona para login
        header('Location: login.php');
        exit;
    }
}

// Função para exibir mensagens (flash)
function flash_get() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!empty($_SESSION['flash_msg'])) {
        $m = $_SESSION['flash_msg'];
        unset($_SESSION['flash_msg']);
        return $m;
    }
    return null;
}
