<?php

$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'funcionarios';

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

//  if ($conexao) {
//     echo("Conexão realizada com sucesso!");
// }else{
//     echo("Erro na conexão com o banco de dados: " . $conexao->connect_error);
// }



?>
