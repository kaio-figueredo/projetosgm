<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

// Proteção: Garante que o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Acesso negado. Usuário não autenticado."]);
    exit;
}

// Recebe os dados JSON enviados pelo JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$id_chamado = isset($data['id_chamado']) ? (int)$data['id_chamado'] : 0;
$novo_status = isset($data['status']) ? trim($data['status']) : '';

// Verifica se os dados chegaram corretamente do frontend
if ($id_chamado === 0 || empty($novo_status)) {
    echo json_encode(["success" => false, "message" => "Dados insuficientes ou incompletos enviados."]);
    exit;
}

$id_tecnico = $_SESSION['user_id']; // Pega o ID do técnico logado por segurança

// Atualiza o status do chamado no banco de dados
// A cláusula "id_tecnico = ?" garante segurança: o técnico só mexe nos próprios chamados
$sql = "UPDATE chamados SET status = ? WHERE id_chamado = ? AND id_tecnico = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Vincula: s (string), i (inteiro), i (inteiro)
    $stmt->bind_param("sii", $novo_status, $id_chamado, $id_tecnico);
    
    if ($stmt->execute()) {
        // Se afetou alguma linha, significa que o banco foi atualizado com sucesso
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Status atualizado com sucesso."]);
        } else {
            // Caso o chamado já estivesse concluído ou não pertencesse a ele
            echo json_encode(["success" => false, "message" => "Nenhuma alteração feita. Verifique se o chamado já está concluído ou pertence a você."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao executar a atualização no banco de dados."]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Erro interno na preparação da query."]);
}
?>