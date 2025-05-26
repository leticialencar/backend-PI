<?php
$senha = 'admin'; // substitua pela senha que você quer salvar
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>
