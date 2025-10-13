<?php
// Conexão com o banco
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "jogos";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pega os dados do formulário
$nome = $_POST['nome'];
$empresa = $_POST['empresa'];
$console = $_POST['console'];
$preco = $_POST['preco'];

// Prepara a inserção
$sql = "INSERT INTO games (nome, empresa, console, preco) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssd", $nome, $empresa, $console, $preco);

// Executa e redireciona
if ($stmt->execute()) {
    echo "<script>alert('Jogo cadastrado com sucesso!'); window.location.href='index.php';</script>";
} else {
    echo "Erro ao salvar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
