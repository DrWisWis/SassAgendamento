<?php
session_start();
include __DIR__ . '/../../conexao.php';

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'ADMIN'){
    header('Location: ../auth/login.php');
    exit();
}

if(isset($_POST['salvar'])){
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $admin_id = $_SESSION['usuario'];


    $sql = "INSERT INTO disponibilidade (admin_id, data, horario) VALUES ( (SELECT id FROM usuarios WHERE email='$admin_id'), '$data', '$hora')";
    $conn->query($sql);
    echo "Disponibilidade adicionada!";
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
    <h2>Adicionar Disponibilidade</h2>
<form method="POST" action="gerar_disponibilidade.php">
    <label>Data Início:</label>
    <input type="date" name="data_inicio" required>

    <label>Data Fim:</label>
    <input type="date" name="data_fim" required>

    <label>Dias da Semana:</label><br>
    <input type="checkbox" name="dias[]" value="1"> Segunda
    <input type="checkbox" name="dias[]" value="2"> Terça
    <input type="checkbox" name="dias[]" value="3"> Quarta
    <input type="checkbox" name="dias[]" value="4"> Quinta
    <input type="checkbox" name="dias[]" value="5"> Sexta
    <input type="checkbox" name="dias[]" value="6"> Sábado
    <input type="checkbox" name="dias[]" value="0"> Domingo

    <label>Horário Início:</label>
    <input type="time" name="hora_inicio" required>

    <label>Horário Fim:</label>
    <input type="time" name="hora_fim" required>

    <label>Intervalo em minutos:</label>
    <input type="number" name="intervalo" value="60" required>

    <button type="submit">Gerar Disponibilidades</button>
</form>
</body>
</html>