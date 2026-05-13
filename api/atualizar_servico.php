<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "sgm_db");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Falha na conexão']);
    exit;
}

$id = $_POST['id_tipo'] ?? '';
$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if (empty($id) || empty($nome)) {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos']);
    exit;
}

// UPDATE na tabela tipos_servico
$stmt = $conn->prepare("UPDATE tipos_servico SET nome = ?, descricao = ? WHERE id_tipo = ?");
$stmt->bind_param("ssi", $nome, $descricao, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>