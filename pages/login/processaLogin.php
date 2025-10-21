<?php
session_start();
include __DIR__ . '/../../conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['tipo'] = $usuario['tipo'];

        if ($usuario['tipo'] == 'ADMIN') {
            header("Location: ./admin/dashboard.php");
        } else {
            header("Location: ./client/cliente.php");
        }
        exit();
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}
?>