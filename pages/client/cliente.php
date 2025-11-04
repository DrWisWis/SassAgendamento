<?php
session_start();
include __DIR__ . '/../../conexao.php';

    if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'CLIENTE'){
        header('Location: ../auth/login.php');
        exit();
    }

// pegar todas as datas disponíveis (status = DISPONIVEL)
$horariosDisponiveis = [];
$sql = "SELECT id, horario, data FROM disponibilidade WHERE status='DISPONIVEL'";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (!isset($row['id'], $row['horario'], $row['data'])) continue;

        $data = $row['data'];
        if (!isset($horariosDisponiveis[$data])) {
            $horariosDisponiveis[$data] = [];
        }
        $horariosDisponiveis[$data][] = [
            'id' => $row['id'],
            'horario' => $row['horario']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../src/style/client.css">
</head>
<body>
    <h1>Pagina do cliente</h1>
    <main class="calendar" role="application" aria-label="Calendário">
    <div class="cal-header">
      <div class="nav" aria-hidden="false">
        <button class="icon" id="prevBtn" aria-label="Mês anterior">◀</button>
      </div>

      <div class="month-year" id="monthYear" aria-live="polite">
        Março 2025
        <small id="subInfo">Calendário</small>
      </div>

      <div class="nav">
        <button class="icon" id="todayBtn" title="Ir para hoje">Hoje</button>
        <button class="icon" id="nextBtn" aria-label="Próximo mês">▶</button>
      </div>
    </div>

    <div class="weekday-row" aria-hidden="true">
      <div>Dom</div><div>Seg</div><div>Ter</div><div>Qua</div><div>Qui</div><div>Sex</div><div>Sáb</div>
    </div>

    <div class="days-grid" id="daysGrid" role="grid" tabindex="0">
      <!-- dias serão renderizados aqui -->
    </div>

    <div class="selected-info" id="selectedInfo" aria-live="polite">
      <div id="selectedText">Nenhuma data selecionada</div>
      <div id="selectedIso" style="font-weight:700;color:var(--text)"></div>
    </div>
  </main>

<div id="modalHorarios" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">
  <div style="background:#fff;padding:20px;border-radius:8px;max-width:360px;width:92%;">
    <h3 id="modalTitle">Escolha o horário</h3>
    <p id="horarioSelecionado" style="font-weight:600;color:#007BFF;margin-top:6px;"></p>

    <div id="listaHorarios" style="margin-top:8px;display:flex;flex-wrap:wrap;gap:6px;"></div>

    <label for="observacao" style="display:block;margin-top:12px;font-weight:600;">Observação (opcional)</label>
    <textarea id="observacao" rows="3" style="width:100%;box-sizing:border-box;margin-top:6px;padding:8px;"></textarea>

    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px;">
      <button id="confirmarAgendamento">Confirmar Agendamento</button>
      <button id="fecharModal">Fechar</button>
    </div>
  </div>
</div>


    <?php include '../../src/includes/menuClient.php'?>


<script>
const diasDisponiveis = <?= json_encode(array_keys($horariosDisponiveis)); ?>;
const horariosDisponiveis = <?= json_encode($horariosDisponiveis); ?>;
</script>

  <script src="../../src/script/agendarCliente.js"></script>
</body>
</html>