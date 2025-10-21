<?php
$host = 'localhost';
$user = "root";
$password = '';
$dbname = "agendamentos";

// Criar conexão
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificar conexão
if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
} else {
    echo("Sucesso na conexão");
}
?>