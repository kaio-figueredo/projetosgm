<?php
// Bloqueia qualquer erro de texto de aparecer e quebrar o JSON
error_reporting(0); 
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "sgm_db"; 

$conn = new mysqli($host, $user, $pass, $db);

// Se falhar a conexão, retorna JSON e para
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Falha na conexão com o banco']));
}

$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if (empty($nome) || empty($descricao)) {
    die(json_encode(['success' => false, 'error' => 'Dados incompletos']));
}

// IMPORTANTE: Verifique se as colunas no seu banco são EXATAMENTE 'nome' e 'descricao'
$sql = "INSERT INTO tipos_servico (nome, descricao) VALUES (?, ?)"; 
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Se a tabela tipos_servicos não existir ou as colunas estiverem erradas, cairá aqui
    die(json_encode(['success' => false, 'error' => 'Erro interno: ' . $conn->error]));
}

$stmt->bind_param("ss", $nome, $descricao);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;