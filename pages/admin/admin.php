<?php
    session_start();

    if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'ADMIN'){
        header('Location: /login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pagina Admin</h1>
    <a href="agendaAdmin.php">Agenda</a>
</body>
</html>