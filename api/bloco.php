<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

// Verificação de segurança: Apenas gestores logados
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        $sql = "SELECT * FROM blocos";
        $result = $conn->query($sql);
        $blocos = [];

        if($result){
            while ($row = $result->fetch_assoc()){
                $blocos[] = $row;
            }
        }
        echo json_encode(["success" => true, "data" => $blocos]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->nome)){
            echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome."]);
            exit;
        }

        $nome = $conn->real_escape_string(trim($data->nome));
        $desc = isset($data->descricao) ? $conn->real_escape_string(trim($data->descricao)) : '';

        $sql = "INSERT INTO blocos (nome, descricao) VALUES ('$nome', '$desc')";

        if($conn->query($sql) === TRUE){
            echo json_encode(["success" => true, "message" => "Bloco criado com sucesso!", "id_bloco" => $conn->insert_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar bloco: " . $conn->error]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->id_bloco) || !isset($data->nome)) {
            echo json_encode(["success" => false, "message" => "Dados incompletos para atualização."]);
            exit;
        }

        $id_bloco = (int)$data->id_bloco;
        $nome = $conn->real_escape_string(trim($data->nome));
        $desc = isset($data->descricao) ? $conn->real_escape_string(trim($data->descricao)) : '';

        $sql = "UPDATE blocos SET nome='$nome', descricao='$desc' WHERE id_bloco = $id_bloco";

        if($conn->query($sql) === TRUE){
            echo json_encode(["success" => true, "message" => "Bloco atualizado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar bloco: " . $conn->error]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->id_bloco)){
            echo json_encode(["success" => false, "message" => "ID do bloco não fornecido."]);
            exit;
        }

        $id_bloco = (int)$data->id_bloco;

        // Inicia transação para garantir que não fiquem dados órfãos se algo falhar
        $conn->begin_transaction();

        try {
            // 1. Deleta chamados vinculados aos ambientes deste bloco
            // O erro FK no seu print indica que 'chamados' dependem de 'ambientes'
            $sqlChamados = "DELETE FROM chamados WHERE id_ambiente IN (SELECT id_ambiente FROM ambientes WHERE id_bloco = $id_bloco)";
            $conn->query($sqlChamados);

            // 2. Deleta os ambientes vinculados a este bloco
            $sqlAmbientes = "DELETE FROM ambientes WHERE id_bloco = $id_bloco";
            $conn->query($sqlAmbientes);

            // 3. Deleta o próprio bloco
            $sqlBloco = "DELETE FROM blocos WHERE id_bloco = $id_bloco";
            
            if($conn->query($sqlBloco) === TRUE){
                $conn->commit();
                echo json_encode(["success" => true, "message" => "Bloco e todos os registros vinculados foram excluídos!"]);
            } else {
                throw new Exception($conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode([
                "success" => false, 
                "message" => "Erro técnico ao excluir: " . $e->getMessage()
            ]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado"]);
        break;
}