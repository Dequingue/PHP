<?php
// login.php
session_start();
require 'config.php';
$msg = flash_get();
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - TaskMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <h1>TaskMaster</h1>
    <div class="theme-toggle">
      <button id="btn-theme">Modo</button>
    </div>
</header>

<main class="container">
    <h2>Login</h2>
    <?php if ($msg): ?>
        <div class="message"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <form action="logar.php" method="post" class="form">
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Senha
            <input type="password" name="senha" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
    <p>Usuário teste: <strong>teste@taskmaster.local</strong> / senha: <strong>123456</strong></p>
</main>

<script>
// Theme toggle (shared JS, style.css cuida do resto)
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
