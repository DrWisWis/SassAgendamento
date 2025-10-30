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
  AND CONCAT(d.data, ' ', d.horario) >= NOW()
ORDER BY d.data ASC, d.horario ASC
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $proximo = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'proximo' => $proximo
    ]);
} else {
    echo json_encode([
        'success' => false,
        'msg' => 'Nenhum agendamento futuro encontrado.'
    ]);
}