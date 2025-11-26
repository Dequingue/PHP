<?php
require 'config.php';
proteger_pagina();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    $_SESSION['flash_msg'] = 'ID inválido.';
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'Media';

    if ($titulo === '') {
        $_SESSION['flash_msg'] = 'O título é obrigatório.';
        header("Location: editar.php?id={$id}");
        exit;
    }

    $stmt = mysqli_prepare($conn, "UPDATE tarefas SET titulo = ?, descricao = ?, prioridade = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $titulo, $descricao, $prioridade, $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_msg'] = 'Tarefa atualizada com sucesso.';
        mysqli_stmt_close($stmt);
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['flash_msg'] = 'Erro ao atualizar: ' . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        header("Location: editar.php?id={$id}");
        exit;
    }
}

// GET: carregar dados
$stmt = mysqli_prepare($conn, "SELECT titulo, descricao, prioridade FROM tarefas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $titulo, $descricao, $prioridade);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    $_SESSION['flash_msg'] = 'Tarefa não encontrada.';
    header('Location: index.php');
    exit;
}
mysqli_stmt_close($stmt);

$msg = flash_get();
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Editar Tarefa - TaskMaster</title>
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
    <h2>Editar Tarefa</h2>
    <?php if ($msg): ?><div class="message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <form method="post" class="form">
        <label>Título
            <input type="text" name="titulo" required value="<?= htmlspecialchars($titulo) ?>">
        </label>
        <label>Descrição
            <textarea name="descricao" rows="6"><?= htmlspecialchars($descricao) ?></textarea>
        </label>
        <label>Prioridade
            <select name="prioridade">
                <option value="Baixa" <?= $prioridade === 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                <option value="Media" <?= $prioridade === 'Media' ? 'selected' : '' ?>>Média</option>
                <option value="Alta" <?= $prioridade === 'Alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </label>
        <button type="submit">Salvar Alterações</button>
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
