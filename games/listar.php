<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "jogos");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se veio um pedido para deletar
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Segurança para evitar SQL Injection

    $stmt = $conn->prepare("DELETE FROM games WHERE idgames = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redireciona para a mesma página para evitar reenvio do formulário e atualizar lista
    header("Location: listar.php");
    exit();
}

// Consulta para buscar os jogos
$sql = "SELECT * FROM games";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Jogos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        button, a.botao-voltar, a.deletar-btn {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            text-decoration: none;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            display: inline-block;
        }

        a.botao-voltar:hover, button:hover, a.deletar-btn:hover {
            background-color: #555;
        }

        .top-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        .jogo-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Botões no topo -->
    <div class="top-buttons">
        <a href="index.php" class="botao-voltar">🔙 Voltar para o Cadastro</a>
        <button id="toggle-dark">🌙 Modo Escuro</button>
    </div>

    <h1>Jogos Cadastrados</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='jogo-item'>";
            echo "<p><strong>Nome:</strong> {$row['nome']}<br>";
            echo "<strong>Produtora:</strong> {$row['produtora']}<br>";
            echo "<strong>Console:</strong> {$row['console']}<br>";
            echo "<strong>Preço:</strong> R$ {$row['preco']}</p>";
            echo "<a href='listar.php?delete_id={$row['idgames']}' class='deletar-btn' onclick='return confirm(\"Tem certeza que deseja deletar este jogo?\");'>🗑️ Deletar</a>";
            echo "<hr></div>";
        }
    } else {
        echo "<p>Nenhum jogo cadastrado.</p>";
    }

    $conn->close();
    ?>

    <!-- Script para alternar modo escuro/claro -->
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
