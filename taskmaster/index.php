<?php
require 'config.php';
proteger_pagina();

$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';
$msg = flash_get();

// Processa busca via GET 'q'
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$like = '%' . $q . '%';

if ($q !== '') {
    $stmt = mysqli_prepare($conn, "SELECT id, titulo, descricao, prioridade, data_criacao FROM tarefas WHERE titulo LIKE ? ORDER BY data_criacao DESC");
    mysqli_stmt_bind_param($stmt, "s", $like);
} else {
    $stmt = mysqli_prepare($conn, "SELECT id, titulo, descricao, prioridade, data_criacao FROM tarefas ORDER BY data_criacao DESC");
}

mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $titulo, $descricao, $prioridade, $data_criacao);

$tarefas = [];
while (mysqli_stmt_fetch($stmt)) {
    $tarefas[] = [
        'id' => $id,
        'titulo' => $titulo,
        'descricao' => $descricao,
        'prioridade' => $prioridade,
        'data_criacao' => $data_criacao
    ];
}
mysqli_stmt_close($stmt);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard - TaskMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <h1>TaskMaster</h1>
    <div class="top-actions">
        <span>Olá, <?= htmlspecialchars($usuario_nome) ?></span>
        <a class="btn small" href="adicionar.php">+ Nova Tarefa</a>
        <a class="btn small" href="logout.php">Sair</a>
        <button id="btn-theme" class="btn small">Tema</button>
    </div>
</header>

<main class="container">
    <h2>Minhas Tarefas</h2>
    <?php if ($msg): ?><div class="message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <form method="get" class="search-form">
        <input type="text" name="q" placeholder="Buscar por título..." value="<?= htmlspecialchars($q) ?>">
        <button type="submit">Buscar</button>
        <?php if ($q !== ''): ?>
            <a href="index.php" class="btn link">Limpar</a>
        <?php endif; ?>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Prioridade</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($tarefas) === 0): ?>
            <tr><td colspan="4">Nenhuma tarefa encontrada.</td></tr>
        <?php else: ?>
            <?php foreach ($tarefas as $t): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($t['titulo'] ?? '') ?>
                        <div class="desc">
                            <?= nl2br(htmlspecialchars($t['descricao'] ?? '')) ?>
                        </div>
                    </td>

                    <td><?= htmlspecialchars($t['prioridade'] ?? '') ?></td>

                    <td><?= htmlspecialchars($t['data_criacao'] ?? '') ?></td>

                    <td class="actions">
                        <a class="btn small" href="editar.php?id=<?= $t['id'] ?>">Editar</a>
                        <a class="btn small danger" href="excluir.php?id=<?= $t['id'] ?>"
                           onclick="return confirm('Excluir essa tarefa?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>

<script>
const btn = document.getElementById('btn-theme');

function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem('tm_theme', t);
    btn.textContent = t === 'dark' ? 'Dark' : 'Light';
}

btn.addEventListener('click', () => {
    const now = document.documentElement.getAttribute('data-theme') === 'dark'
        ? 'light' : 'dark';
    applyTheme(now);
});

const saved = localStorage.getItem('tm_theme') || 'light';
applyTheme(saved);
</script>
</body>
</html>
