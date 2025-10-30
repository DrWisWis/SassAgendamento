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
    <link rel="stylesheet" href="../../src/style/admin.css">
</head>
<body>
    <h1>Dashboard</h1>
    <div class="line"></div>

    <div class="card">
    <p>Próximo Agendamento</p>
    <div id="agendamento-info">
      <p class="no-agendamento">Carregando...</p>
    </div>
  </div>

  <script>
    async function carregarProximoAgendamento() {
      try {
        const response = await fetch('proximo_agendamento.php');
        const data = await response.json();

        const infoDiv = document.getElementById('agendamento-info');
        infoDiv.innerHTML = ''; // limpa antes de mostrar

        if (data.success && data.proximo) {
          const ag = data.proximo;

          infoDiv.innerHTML = `
          <div class="agendamento">
            <div class="info">
                <img src="../../src/assets/category.png" alt="">
                <p>${ag.cliente_nome}</p>
            </div>
            <div class="info">
                <img src="../../src/assets/category.png" alt="">
                <p>${ag.data}</p>
            </div>
            <div class="info">
                <img src="../../src/assets/category.png" alt="">
                <p>${ag.horario}</p>
            </div>
          </div>  
                      <p class="info">${ag.observacao || 'Nenhuma'}</p>
          `;
        } else {
          infoDiv.innerHTML = `<p class="no-agendamento">${data.msg}</p>`;
        }

      } catch (error) {
        document.getElementById('agendamento-info').innerHTML =
          `<p class="no-agendamento">Erro ao carregar dados.</p>`;
        console.error('Erro:', error);
      }
    }

    carregarProximoAgendamento();
  </script>

    <div class="line"></div>
    <nav>
        <div class="icon">
            <img src="../../src/assets/category.png" alt="">
            <p>Dashboard</p>
        </div>
        <div class="icon">
            <img src="../../src/assets/message.png" alt="">
            <p>Mensagens</p>
        </div>
        <a href="agendaAdmin.php">
            <div class="icon">
                <img src="../../src/assets/setting-2.png" alt="">
                <p>Configurações</p>
            </div>
        </a>
    </nav>
</body>
</html>