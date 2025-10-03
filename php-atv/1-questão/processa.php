<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nota1 = $_POST["nota1"];
    $nota2 = $_POST["nota2"];
    $nota3 = $_POST["nota3"];

    $media = ($nota1 + $nota2 + $nota3) / 3;

    // Define classe CSS baseada no resultado
    if ($media >= 6) {
        $situacao = "Aprovado";
        $classe = "aprovado";
    } elseif ($media >= 4) {
        $situacao = "Recuperação";
        $classe = "recuperacao";
    } else {
        $situacao = "Reprovado";
        $classe = "reprovado";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Média</title>
    <link rel="stylesheet" href="processar.css">
</head>
<body>
    <div class="container resultado">
        <h2>Resultado</h2>
        <p>Média: <strong><?php echo number_format($media, 2, ',', '.'); ?></strong></p>
        <p class="<?php echo $classe; ?>">Situação: <?php echo $situacao; ?></p>
        <a href="index.html" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
