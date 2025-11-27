<?php
// seed.php - executar uma vez (ex: http://localhost/taskmaster/seed.php)
require 'config.php';

// Cria tabelas
$sql1 = "CREATE TABLE IF NOT EXISTS usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL UNIQUE,
 senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$sql2 = "CREATE TABLE IF NOT EXISTS tarefas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 titulo VARCHAR(150) NOT NULL,
 descricao TEXT,
 prioridade ENUM('Baixa','Media','Alta') DEFAULT 'Media',
 data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo "Tabelas criadas ou já existentes.<br>";
} else {
    echo "Erro ao criar tabelas: " . mysqli_error($conn) . "<br>";
    exit;
}

// Inserir usuário teste se não existir
$email = 'teste@taskmaster.local';
$nome = 'Usuário Teste';
$senha_texto = '123456';
$senha_hash = password_hash($senha_texto, PASSWORD_DEFAULT);

// Verifica se já existe
$stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$exists = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if (!$exists) {
    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha_hash);
    if (mysqli_stmt_execute($stmt)) {
        echo "Usuário teste criado: {$email} / senha: 123456<br>";
    } else {
        echo "Erro ao inserir usuário: " . mysqli_error($conn) . "<br>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Usuário teste já existe: {$email}<br>";
}

echo "<br><a href='login.php'>Ir para login</a>";
