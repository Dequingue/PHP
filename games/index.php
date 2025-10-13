<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Jogos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <!-- Botão de alternar modo escuro -->
    <button id="toggle-dark" style="position: absolute; top: 20px; right: 20px;">🌙 Modo Escuro</button>

    <div class="container">
        <h1>Cadastro de Jogo</h1>
        <form action="salvar.php" method="POST">
            <label for="nome">Nome do Jogo:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="empresa">Empresa Produtora:</label>
            <input type="text" id="empresa" name="empresa" required>

            <label for="console">Console:</label>
            <input type="text" id="console" name="console" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" step="0.01" id="preco" name="preco" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <!-- Script para alternar o modo -->
    <script>
        const toggleButton = document.getElementById('toggle-dark');
        toggleButton.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                toggleButton.textContent = '☀️ Modo Claro';
            } else {
                toggleButton.textContent = '🌙 Modo Escuro';
            }
        });
    </script>
</body>
</html>
