<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ultima_menstruacao = $_POST["ultima_menstruacao"];
    $duracao_ciclo = (int) $_POST["duracao_ciclo"];

    // Calcula a próxima menstruação
    $proxima_menstruacao = date('d/m/Y', strtotime("+$duracao_ciclo days", strtotime($ultima_menstruacao)));

    // Calcula período fértil (12º ao 16º dia do ciclo)
    $periodo_fertil_inicio = date('d/m/Y', strtotime("+11 days", strtotime($ultima_menstruacao)));
    $periodo_fertil_fim = date('d/m/Y', strtotime("+15 days", strtotime($ultima_menstruacao)));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Previsão do Ciclo</title>
    <link rel="stylesheet" href="estilo_ciclo.css">
</head>
<body>
    <div class="container resultado">
        <h2>Previsão do Ciclo Menstrual</h2>
        <p>Próxima menstruação: <strong><?php echo $proxima_menstruacao; ?></strong></p>
        <p>Período fértil: <strong><?php echo $periodo_fertil_inicio; ?></strong> ao <strong><?php echo $periodo_fertil_fim; ?></strong></p>
        <a href="index.html" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
