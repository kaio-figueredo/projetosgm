<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

// Proteção: Apenas Gestores
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

// Recebe os dados em formato JSON enviados pelo frontend
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id_chamado']) && isset($data['id_tecnico'])) {
    
    // Tratamento dos dados
    $id_chamado = (int) $data['id_chamado'];
    $id_tecnico = (int) $data['id_tecnico'];
    
    // Sanitização das strings usando o padrão mysqli
    $prioridade = $conn->real_escape_string($data['prioridade'] ?? 'baixa');
    $data_prevista = $conn->real_escape_string($data['data_prevista'] ?? '');
    $status = $conn->real_escape_string($data['status'] ?? 'em_execucao'); // Recebe o status enviado pelo JS

    // Prepara a query de UPDATE (Proteção contra SQL Injection)
    $sql = "UPDATE chamados SET 
                id_tecnico = ?, 
                prioridade = ?, 
                data_previsao_conclusao = ?, 
                status = ? 
            WHERE id_chamado = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Vincula os parâmetros: i (inteiro), s (string), s (string), s (string), i (inteiro)
        $stmt->bind_param("isssi", $id_tecnico, $prioridade, $data_prevista, $status, $id_chamado);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Técnico atribuído e status atualizado com sucesso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar o chamado no banco."]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Erro na preparação da query."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dados obrigatórios (ID do Chamado ou ID do Técnico) não fornecidos."]);
}
?>