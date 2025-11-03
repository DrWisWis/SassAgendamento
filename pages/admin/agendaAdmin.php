<?php
session_start();
include __DIR__ . '/../../conexao.php';

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'ADMIN') {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_POST['salvar'])) {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $admin_id = $_SESSION['usuario'];

    $sql = "INSERT INTO disponibilidade (admin_id, data, horario) 
            VALUES ((SELECT id FROM usuarios WHERE email='$admin_id'), '$data', '$hora')";
    $conn->query($sql);
    echo "Disponibilidade adicionada!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../../src/style/adm.css">
</head>
<body>
    <h1>Configurações</h1>
    <div class="line"></div>

    <div class="settings">
        <div class="profile">
            <!-- <img src="../../src/assets/user.png" alt="Foto de perfil" class="avatar">
            <h2><?php echo htmlspecialchars($nome); ?></h2> -->
        </div>

        <div class="tabs">
            <button class="tab active" id="tab-barber">Barber</button>
            <button class="tab" id="tab-clients">Clients</button>
        </div>

        <div class="content" id="content-barber">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Data Início</label>
                    <input type="date" name="data_inicio" required>
                </div>

                <div class="form-group">
                    <label>Data Fim</label>
                    <input type="date" name="data_fim" required>
                </div>

                <div class="form-group">
                    <label>Dias da Semana</label>
                    <div class="dias">
                        <label><input type="checkbox" name="dias[]" value="1"> Seg</label>
                        <label><input type="checkbox" name="dias[]" value="2"> Ter</label>
                        <label><input type="checkbox" name="dias[]" value="3"> Qua</label>
                        <label><input type="checkbox" name="dias[]" value="4"> Qui</label>
                        <label><input type="checkbox" name="dias[]" value="5"> Sex</label>
                        <label><input type="checkbox" name="dias[]" value="6"> Sáb</label>
                        <label><input type="checkbox" name="dias[]" value="0"> Dom</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Horário Início</label>
                    <input type="time" name="hora_inicio" required>
                </div>

                <div class="form-group">
                    <label>Horário Fim</label>
                    <input type="time" name="hora_fim" required>
                </div>

                <div class="form-group">
                    <label>Intervalo (min)</label>
                    <input type="number" name="intervalo" value="30" required>
                </div>

                <button type="submit" class="btn">Gerar Disponibilidades</button>
            </form>
        </div>

        <div class="content hidden" id="content-clients">
            <p>Lista de clientes (em breve)</p>
        </div>
    </div>

    <div class="line"></div>
    
    <?php include '../../src/includes/menuAdmin.php'?>

    <script>
        const tabBarber = document.getElementById('tab-barber');
        const tabClients = document.getElementById('tab-clients');
        const contentBarber = document.getElementById('content-barber');
        const contentClients = document.getElementById('content-clients');

        tabBarber.onclick = () => {
            tabBarber.classList.add('active');
            tabClients.classList.remove('active');
            contentBarber.classList.remove('hidden');
            contentClients.classList.add('hidden');
        };

        tabClients.onclick = () => {
            tabClients.classList.add('active');
            tabBarber.classList.remove('active');
            contentClients.classList.remove('hidden');
            contentBarber.classList.add('hidden');
        };
    </script>
</body>
</html>