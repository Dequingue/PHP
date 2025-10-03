<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temperaturas = [
        $_POST["dia1"], $_POST["dia2"], $_POST["dia3"], 
        $_POST["dia4"], $_POST["dia5"], $_POST["dia6"], $_POST["dia7"]
    ];

    $media = array_sum($temperaturas) / count($temperaturas);

    if ($media < 15) {
        $situacao = "Semana fria ❄️";
        $classe = "fria";
    } elseif ($media <= 25) {
        $situacao = "Semana agradável 🙂";
        $classe = "agradavel";
    } else {
        $situacao = "Semana quente 🔥";
        $classe = "quente";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Temperaturas</title>
    <link rel="stylesheet" href="estilo_temp.css">
</head>
<body>
    <div class="container resultado">
        <h2>Resultado da Semana</h2>
        <p>Média: <strong><?php echo number_format($media, 1, ",", "."); ?> °C</strong></p>
        <p class="<?php echo $classe; ?>"><?php echo $situacao; ?></p>
        <a href="index.html" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
