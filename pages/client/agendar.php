<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

include __DIR__ . '/../../conexao.php';

// verifica sessão
    if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'CLIENTE'){
        header('Location: ../auth/login.php');
        exit();
    }

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['disponibilidade_id'])) {
    echo json_encode(['success' => false, 'msg' => 'Requisição inválida.']);
    exit;
}

$cliente_id = intval($_SESSION['usuario_id']);
$disponibilidade_id = intval($input['disponibilidade_id']);
$observacao = isset($input['observacao']) ? trim($input['observacao']) : null;

if ($disponibilidade_id <= 0) {
    echo json_encode(['success' => false, 'msg' => 'ID de disponibilidade inválido.']);
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT status, data, horario FROM disponibilidade WHERE id = ? FOR UPDATE");
    $stmt->bind_param("i", $disponibilidade_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $conn->rollback();
        echo json_encode(['success' => false, 'msg' => 'Disponibilidade não encontrada.']);
        exit;
    }

    $row = $res->fetch_assoc();

    if ($row['status'] !== 'DISPONIVEL') {
        $conn->rollback();
        echo json_encode(['success' => false, 'msg' => 'Horário já ocupado.']);
        exit;
    }

    $stmtIns = $conn->prepare("INSERT INTO agendamentos (cliente_id, disponibilidade_id, observacao) VALUES (?, ?, ?)");
    $stmtIns->bind_param("iis", $cliente_id, $disponibilidade_id, $observacao);
    if (!$stmtIns->execute()) {
        $conn->rollback();
        echo json_encode(['success' => false, 'msg' => 'Erro ao inserir agendamento.']);
        exit;
    }

    $stmtUpd = $conn->prepare("UPDATE disponibilidade SET status = 'OCUPADO' WHERE id = ?");
    $stmtUpd->bind_param("i", $disponibilidade_id);
    if (!$stmtUpd->execute()) {
        $conn->rollback();
        echo json_encode(['success' => false, 'msg' => 'Erro ao atualizar disponibilidade.']);
        exit;
    }

    $conn->commit();

    ob_clean(); // limpa qualquer saída antes
    echo json_encode([
        'success' => true,
        'msg' => 'Agendamento realizado com sucesso!',
        'disponibilidade_id' => $disponibilidade_id,
        'data' => $row['data'],
        'horario' => $row['horario']
    ]);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'msg' => 'Erro inesperado: ' . $e->getMessage()]);
    exit;
}