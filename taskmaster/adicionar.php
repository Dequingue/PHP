<?php
require 'config.php';
proteger_pagina();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'Media';

    if ($titulo === '') {
        $_SESSION['flash_msg'] = 'O título é obrigatório.';
        header('Location: adicionar.php');
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO tarefas (titulo, descricao, prioridade) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $titulo, $descricao, $prioridade);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_msg'] = 'Tarefa salva com sucesso.';
        mysqli_stmt_close($stmt);
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['flash_msg'] = 'Erro ao salvar tarefa: ' . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        header('Location: adicionar.php');
        exit;
    }
}
$msg = flash_get();
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Adicionar Tarefa - TaskMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <h1>TaskMaster</h1>
    <div class="top-actions">
        <a href="index.php" class="btn small">Voltar</a>
        <button id="btn-theme" class="btn small">Tema</button>
    </div>
</header>

<main class="container">
    <h2>Adicionar Tarefa</h2>
    <?php if ($msg): ?><div class="message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="post" class="form">
        <label>Título
            <input type="text" name="titulo" required>
        </label>
        <label>Descrição
            <textarea name="descricao" rows="6"></textarea>
        </label>
        <label>Prioridade
            <select name="prioridade">
                <option value="Baixa">Baixa</option>
                <option value="Media" selected>Média</option>
                <option value="Alta">Alta</option>
            </select>
        </label>
        <button type="submit">Salvar</button>
    </form>
</main>

<script>
const btn = document.getElementById('btn-theme');
function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem('tm_theme', t);
    btn.textContent = t === 'dark' ? 'Dark' : 'Light';
}
btn.addEventListener('click', ()=> {
    const now = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    applyTheme(now);
});
const saved = localStorage.getItem('tm_theme') || 'light';
applyTheme(saved);
</script>
</body>
</html>
