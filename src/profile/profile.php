<?php
session_start();
include('../../config/config.php');
include('../viacep/viacep.php');

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$nivelPermissao = $_POST['nivel'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (nome_usuario, cpf_usuario, )";