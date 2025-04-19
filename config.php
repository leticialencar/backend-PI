<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "cashhive_system";

$mysqli = new mysqli($host, $usuario, $senha, $banco);

if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}
else{
    echo "Banco de dados iniciado com sucesso! Pode mexer :)";
}