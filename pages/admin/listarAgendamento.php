<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include __DIR__ . '/../../conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'ADMIN') {
    echo json_encode(['success' => false, 'msg' => 'Acesso negado.']);
    exit;
}

$admin_id = intval($_SESSION['usuario_id']);

$sql = "
SELECT 
    a.id AS agendamento_id,
    a.observacao,
    d.data,
    d.horario,
    u.nome AS cliente_nome,
    u.email AS cliente_email
FROM agendamentos a
INNER JOIN disponibilidade d ON a.disponibilidade_id = d.id
INNER JOIN usuarios u ON a.cliente_id = u.id
WHERE d.admin_id = ?
AND d.data = CURDATE()
ORDER BY d.data ASC, d.horario ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $agendamentos = [];
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row;
    }
    echo json_encode(['success' => true, 'agendamentos' => $agendamentos]);
} else {
    echo json_encode(['success' => false, 'msg' => 'Nenhum agendamento encontrado.']);
}