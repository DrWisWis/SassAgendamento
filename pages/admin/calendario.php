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

<script>
async function carregarAgenda() {
    try {
        const response = await fetch('listarAgendamento.php');
        const data = await response.json();
        const list = document.getElementById('agenda-list');
        list.innerHTML = '';

        if (data.success && data.agendamentos.length > 0) {
            let horaAtual = '';
            data.agendamentos.forEach(item => {
                const hora = item.horario.substring(0, 2) + "H";
                if (hora !== horaAtual) {
                    horaAtual = hora;
                    const label = document.createElement('div');
                    label.className = 'time-label';
                    label.textContent = hora;
                    list.appendChild(label);
                }

                const div = document.createElement('div');
                div.className = 'appointment';
                div.innerHTML = `
                    <h4>${item.cliente_nome}</h4>
                    <p>${item.observacao || 'Sem observação'}</p>
                    <p class="appointment-time">${item.data} • ${item.horario}</p>
                `;
                list.appendChild(div);
            });
        } else {
            list.innerHTML = `<p style="text-align:center;color:#777;">${data.msg}</p>`;
        }

    } catch (error) {
        console.error(error);
        document.getElementById('agenda-list').innerHTML =
            `<p style="text-align:center;color:#777;">Erro ao carregar agendamentos.</p>`;
    }
}

carregarAgenda();
</script>

<div class="line"></div>

    <nav>
          <div class="icon">
            <img src="../../src/assets/category.png" alt="">
            <p>Dashboard</p>
          </div>
        <a href="calendario.php">
          <div class="icon">
            <img src="../../src/assets/setting-2.png" alt="">
            <p>Calendario</p>
          </div>
        </a>
        <a href="#">
          <div class="icon">
            <img src="../../src/assets/message.png" alt="">
            <p>Mensagens</p>
          </div>
        </a>
        <a href="agendaAdmin.php">
            <div class="icon">
                <img src="../../src/assets/setting-2.png" alt="">
                <p>Configurações</p>
            </div>
        </a>
    </nav>

    <script src="../../src/script/proximoAgendamento.js"></script>
</body>
</html>