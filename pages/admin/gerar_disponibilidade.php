<?php
session_start();
include __DIR__ . '/../../conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'ADMIN') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_SESSION['usuario_id'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $dias = $_POST['dias']; // array de dias da semana (0=domingo, 1=segunda,...)
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $intervalo = intval($_POST['intervalo']);

    $current_date = strtotime($data_inicio);
    $end_date = strtotime($data_fim);

    while ($current_date <= $end_date) {
        $dia_semana = date('w', $current_date); // 0=domingo ... 6=sabado

        if (in_array($dia_semana, $dias)) {
            $hora_atual = strtotime($hora_inicio);
            $hora_final = strtotime($hora_fim);

            while ($hora_atual < $hora_final) {
                $hora_str = date('H:i:s', $hora_atual);
                $data_str = date('Y-m-d', $current_date);

                // insere no banco
                $sql = "INSERT INTO disponibilidade (admin_id, data, horario) VALUES ('$admin_id', '$data_str', '$hora_str')";
                mysqli_query($conn, $sql);

                // incrementa pelo intervalo
                $hora_atual = strtotime("+$intervalo minutes", $hora_atual);
            }
        }

        $current_date = strtotime("+1 day", $current_date);
    }

    echo "Disponibilidades geradas com sucesso!";
}
?>