<?php

include 'conexao.php';

$nome = $_POST['nome'];
$funcao = $_POST['funcao'];
$salario = $_POST['salario'];

$sql = "INSERT INTO funcionario (nome, funcao, salario) VALUES ('$nome', '$funcao', $salario)";


if ($conexao->query($sql) === TRUE) {
    echo "Novo funcionário cadastrado com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conexao->error;
}
$conexao->close();

?>