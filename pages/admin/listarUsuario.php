<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include __DIR__ . '/../../conexao.php';

if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'ADMIN') {
    echo json_encode(['success' => false, 'msg' => 'Acesso negado']);
    exit;
}

$sql = "SELECT nome, email, 'Ativo' AS status FROM usuarios WHERE tipo = 'CLIENTE' ORDER BY nome ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    echo json_encode(['success' => true, 'clientes' => $clientes]);
} else {
    echo json_encode(['success' => false, 'msg' => 'Nenhum cliente encontrado']);
}