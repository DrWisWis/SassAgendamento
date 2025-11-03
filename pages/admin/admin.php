<?php
    session_start();

    if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'ADMIN'){
        header('Location: ../auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../../src/style/adm.css">
</head>
<body>
    <h1>Dashboard</h1>
    <div class="line"></div>

    <div class="card">
    <p class="next">Próximo Agendamento</p>
    <div id="agendamento-info">
      <p class="no-agendamento">Carregando...</p>
    </div>
  </div>

    <div class="line"></div>

    <?php include '../../src/includes/menuAdmin.php'?>

    <script src="../../src/script/proximoAgendamento.js"></script>
</body>
</html>