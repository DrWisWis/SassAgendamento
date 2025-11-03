<?php
session_start();
include __DIR__ . '/../../conexao.php';

// Apenas ADMIN pode ver
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'ADMIN') {
    header('Location: /login.php');
    exit();
}

$admin_id = intval($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda - Admin</title>
<link rel="stylesheet" href="../../src/style/adm.css">
</head>
<body>

    <h1>Calendario</h1>
    <div class="line"></div>

    <div class="card">
    <p class="next">Próximo Agendamento</p>
    <div id="agendamento-info">
      <p class="no-agendamento">Carregando...</p>
    </div>
  </div>



    <div class="agenda-container">
        <div class="agenda-header">
            <span>Agenda</span>
            <span>Visualização diária</span>
        </div>
        <div class="agenda-list" id="agenda-list">
            <p style="text-align:center;color:#777;">Carregando agendamentos...</p>
        </div>
    </div>

<div class="line"></div>

<?php include '../../src/includes/menuAdmin.php'?>

    <script src="../../src/script/proximoAgendamento.js"></script>
    <script src="../../src/script/listarAgenda.js"></script>
</body>
</html>